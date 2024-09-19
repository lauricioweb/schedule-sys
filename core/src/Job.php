<?php
class Job extends Novel
{
    private $conf = array(
        "logMaxSize" => 25 //mb
    );
    //
    private $time_start = 0;
    private $time_total = 0;

    // loops
    private $current_loop = 0;
    private $loops_with_events = [];

    // caller file
    private $caller, $caller_path, $caller_fn;
    private $caller_content; // verify changes

    // log files
    private $id_file, $date_file, $log_file;
    private $colors; // log colors

    public function __construct($bypass = false)
    {
        $caller = debug_backtrace();
        // caller data
        $this->caller = $caller[0]['file'];
        $this->caller_path = dirname($this->caller);
        $this->caller_fn = basename($this->caller);
        $this->caller_content = md5_file($this->caller);
        // log files
        $this->id_file = $this->caller_path . "/log/" . $this->caller_fn . "@id";
        $this->date_file = $this->caller_path . "/log/" . $this->caller_fn . "@date";
        $this->log_file = $this->caller_path . "/log/" . $this->caller_fn . "@log";
        if (!$bypass and !is_writable($this->log_file)) {
            $this->say("⚬ CAN'T WRITE IN LOG DIR..", 'red');
            exit;
        }
        // log colors
        $this->colors = $this->getColors();
    }
    public static function run_all_jobs()
    {
        global $_APP;
        if (!@$_APP['JOBS']) return false;
        $total_jobs = count($_APP['JOBS']);
        Mason::say("∴ $total_jobs jobs from {$_APP['NAME']}", true, 'blue');
        // check if autoplay is available
        $stop_fn = realpath(Novel::DIR_ROOT . '/src/jobs/stop');
        if (file_exists($stop_fn)) {
            Mason::say("<magenta>(!) autoplay is disabled</end>");
            Mason::say("remove: $stop_fn");
            exit;
        }
        foreach ($_APP['JOBS'] as $fn) {
            // already running
            if (self::check_fn_process($fn)) {
                Mason::say("✔ php {$fn} <magenta>(already running)</end>");
            }
            // run
            else {
                $dir = realpath(Novel::DIR_ROOT);
                $exec = "php $dir/$fn";
                Mason::say("<green>► php {$fn}</end>");
                exec("$exec > /dev/null &");
            }
        }
    }
    public function start()
    {
        $this->check_caller_process();
        $this->check_caller_changes();
        $this->check_caller_status();
        $this->current_loop = $this->current_loop + 1;
        $this->setDate();
        set_time_limit(0);
        $this->time_start = microtime(true);
        if ($this->current_loop === 1) $this->say('⚬ START.');
        else {
            $back_1_loop = intval($this->current_loop - 1);
            $back_2_loops = intval($this->current_loop - 2);
            if (
                @!$this->loops_with_events[$back_1_loop]
                and @$this->loops_with_events[$back_2_loops]
            ) {
                echo "(" . date("H:i:s") . ") ⚬ WAITING FOR NEW EVENTS..." . PHP_EOL;
            }
        }
        //file_put_contents($this->caller_lock, "");
    }
    private function check_caller_changes()
    {
        clearstatcache();
        $current_caller_content = md5_file($this->caller);
        if ($current_caller_content !== $this->caller_content) {
            $this->say("⚬ FILE HAS CHANGED.", "red");
            $this->end();
        }
    }
    private function check_caller_status()
    {
        clearstatcache();
        if (file_exists("{$this->caller}-stop")) {
            $this->say("⚬ STOPPED BY DASHBOARD.", "red");
            $this->end();
        }
        if (file_exists("{$this->caller}-restart")) {
            @unlink("{$this->caller}-restart");
            $this->say("⚬ RESTARTED BY DASHBOARD. AWAITING NEW EXECUTION...", "blue");
            $this->end();
        }
    }
    private function setDate()
    {
        file_put_contents($this->date_file, time());
    }
    public function set_last_id($id, $say = true)
    {
        file_put_contents($this->id_file, $id);
        if ($say) $this->say("SET LAST ID: <blue>$id</end>", true, true, "pink");
    }
    public function get_last_id()
    {
        if (file_exists($this->id_file)) {
            $last_id = file_get_contents($this->id_file);
        } else {
            file_put_contents($this->id_file, 0);
            $last_id = 0;
        }
        $this->say("⚬ CONTINUE AFTER LAST ID: <blue>$last_id</end>...", true, true, "pink");
        return $last_id;
    }
    private function secToTime($seconds)
    {
        $t = round($seconds);
        return sprintf('%02d:%02d:%02d', (int)($t / 3600), (int)($t / 60 % 60), $t % 60);
    }
    public function log($message)
    {
        if (file_exists($this->log_file) and filesize($this->log_file) >= intval($this->conf['logMaxSize'] * 1024 * 1024)) {
            // clear log file
            file_put_contents($this->log_file, "", FILE_APPEND);
        }
        file_put_contents($this->log_file, "[" . date("Y-m-d H:i:s") . "] $message" . PHP_EOL, FILE_APPEND);
    }
    public function end()
    {
        $this->time_total = number_format((microtime(true) - $this->time_start), 4);
        $this->log("END. TOTAL RUNTIME: " . $this->secToTime($this->time_total));
        //@unlink($this->caller_lock);
        exit;
    }
    public function check_caller_process()
    {
        exec("ps aux | grep '{$this->caller_fn}' | grep -v grep | awk '{print $2}'", $findProcess);
        if (count($findProcess) > 1) {
            echo '(!) ALREADY RUNNING.' . PHP_EOL;
            exit;
        }
    }
    public function now()
    {
        return date("Y-m-d H:i:s");
    }
    public static function check_fn_process($fn)
    {
        exec("ps aux | grep '{$fn}' | grep -v grep | awk '{print $2}'", $findProcess);
        if (count($findProcess) > 0) return true;
        else return false;
    }
    public function validate($res)
    {
        // Check errors
        $return = json_decode($res['res']);
        if ($res['err']) {
            $this->say("(!) cURL Error: {$res['err']}", false, true, "red");
            exit;
        }
        if (isset($return->message)) {
            $this->say("(!) API Message: $return->message", false, true, "red");
            exit;
        }
        if (isset($return->api->error)) {
            $this->say("(!) API Error: $return->api->error", false, true, "red");
            exit;
        }
    }
    public function say($text, $color = '')
    {
        $this->loops_with_events[$this->current_loop] = 1;
        $timeStamp = "(" . date("H:i:s") . ") ";
        $colorCode = $color ? $this->colors[$color] : '';

        if (is_array($text)) {
            echo $timeStamp . print_r($text, true) . PHP_EOL;
            $this->log(print_r($text, true));
        } else {
            $text = $this->addTagColorsToText($text);
            $formattedText = "{$colorCode}{$text}{$this->colors['end']}";
            echo $timeStamp . $formattedText . PHP_EOL;
            $this->log($formattedText);
        }
    }
    public function header($text, $color = '')
    {
        $this->loops_with_events[$this->current_loop] = 1;
        $timeStamp = "(" . date("H:i:s") . ") ";
        $headerWidth = 50;
        $headerSymbol = "·";
        $colorCode = $color ? $this->colors[$color] : '';

        $headerLine = str_repeat($headerSymbol, $headerWidth);
        $formattedHeader = "{$colorCode}{$headerLine}{$this->colors['end']}";
        $formattedText = "{$colorCode}{$this->addTagColorsToText($text)}{$this->colors['end']}";

        echo $timeStamp . $formattedHeader . PHP_EOL;
        $this->log($formattedHeader);

        echo $timeStamp . $formattedText . PHP_EOL;
        $this->log($formattedText);

        echo $timeStamp . $formattedHeader . PHP_EOL;
        $this->log($formattedHeader);
    }
    private function addTagColorsToText($text)
    {
        foreach ($this->colors as $key => $value) {
            $text = str_replace("<$key>", $value, $text);
            $text = str_replace("</$key>", $this->colors['end'], $text);
        }
        return $text;
    }
    private function getColors()
    {
        $colors = array(
            'header' => "\033[95m",
            //
            'blue' => "\033[94m",
            'cyan' => "\033[36m",
            'green' => "\033[92m",
            'yellow' => "\033[93m",
            'red' => "\033[91m",
            'pink' => "\033[35m",
            //
            'blink' => "\033[5m",
            'strong' => "\033[1m",
            'u' => "\033[4m",
            'end' => "\033[0m"
        );
        return $colors;
    }
}
