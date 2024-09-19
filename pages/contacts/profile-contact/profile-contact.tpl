<div class="main d-flex gap-3 align-items-center justify-content-center flex-column">

  <h2 class="text-white mb-2">Informações do contato</h2>


  <div class="col-12 d-flex align-items-center justify-content-center">
    <div class="w-25">

      <?php      
foreach($res as $data){

  if(isset($_GET["show-form"]) && $_GET["show-form"] == 1){
  ?>
      <form action="<?= PAGE_POST ?>" method="POST" enctype="multipart/form-data" class="bg-dark border border-white
        text-white w-25 p-3"
        style="position: fixed; top:100px; z-index: 300; display:flex; flex-direction: column; gap:10px;">
        <a style="position: absolute; right:2px; top:3px;" href="?ctt_id=<?= @$data["ctt_id"]; ?>"
          class="btn btn-warning btn-sm"><i class="bi bi-x-circle"></i></a>
        <div class="form-group">
          <label for="profile_picture">Selecione uma imagem</label>
          <input type="hidden" name="id_profile" value="<?= $data["ctt_id"]; ?>" />
          <input type="file" class="form-control-file" id="profile_picture" name="profile-picture" required>
        </div>
        <button type="submit" class="btn btn-success btn-block">Enviar</button>
      </form>
      <?php 
  }
if($data["ctt_picture"] === null){
  ?>

      <div class=" w-100" style=" position:relative;">
        <img class="rounded-circle w-75" src="/assets/images/default-user.png" alt="img user">
        <a style="position: absolute; top:3px;" href="?ctt_id=<?= @$data["ctt_id"]; ?>&show-form=1"
          class="btn btn-primary btn-sm"><i class="bi bi-upload"></i></a>
      </div>
      <?php
    }else{
      ?>
      <div class=" w-75" style="position:relative;">
        <img class="rounded-circle border border-white" style="object-fit: contain;
           width: 100%;
            height: 100%;
            object-fit: cover;
            
        " src="/uploads/profile-users/<?= @$data["ctt_picture"]; ?>" alt="img user">
        <a style="position: absolute; top:3px;" href="?ctt_id=<?= @$data["ctt_id"]; ?>&show-form=1"
          class="btn btn-primary btn-sm"><i class="bi bi-upload"></i></a>
      </div>

      <?php
    }
?>
    </div>
    <div class="text-white border border-light p-4">
      <p><i class="ri-file-user-fill"></i>
        <?= $data["ctt_name"]; ?></p>
      <p><i class="ri-mail-fill"></i>
        <?= $data["ctt_email"]; ?></p>
      <p><i class="ri-map-pin-fill"></i>
        <?= $data["ctt_adress"]; ?></p>
      <p><i class="ri-phone-fill"></i>
        <?= $data["ctt_contact"]; ?></p>
      <p><i class="ri-cake-fill"></i>
        <?= $data["ctt_date_born"]; ?></p>

    </div>
  </div>
  <div>
    <a href="/contacts" class="btn btn-primary btn-sm"><i class="ri-home-2-fill"></i></a>
    <a href="form?ctt_id=<?=$data["ctt_id"]?>" class="btn btn-warning btn-sm"><i class="ri-edit-box-fill"></i></a>
    <a href="<?= PAGE_POST ?>?ctt_id=<?=$data["ctt_id"]?>" class=" btn btn-danger btn-sm"><i
        class="ri-delete-bin-fill"></i></a>


  </div>
</div>

<?php
}
?>