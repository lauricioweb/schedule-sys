<header>
  <h2 class="text-center text-white"><?= $_title ?></h2>

</header>

<div class="container-lg border border-light bg-dark p-1">

  <form action="<?= PAGE_POST ?>" method="POST" novalidate>
    <input type="hidden" name="ctt_id" value="<?= $ctt_id ?>" />
    <div class="d-flex p-2 text-white gap-2 w-100 align-itens-center justify-content-center">

      <input type="hidden" class="form-control" value="1" name="ctt_favorite">

      <div class="form-group w-100">
        <label for="nome">Nome</label>
        <input type="text" id="Nome" class="form-control" value="<?= @$res[0]['ctt_name']?>" name="ctt_name"
          placeholder="Jhon Doe">
      </div>

      <div class="form-group w-100">
        <label for="email">Email</label>
        <input class="form-control" type="text" value="<?= @$res[0]['ctt_email']?>" name="ctt_email"
          placeholder="exemplo@gmail.com">
      </div>

    </div>

    <div class="d-flex p-2 text-white gap-2 w-100 align-itens-center justify-content-center">

      <div class="form-group w-100">
        <label for="endereco">Endereço</label>
        <input type="text" class="form-control" value="<?= @$res[0]['ctt_adress']?>" id="endereco" name="ctt_adress"
          placeholder="Av. sn centro nº 00">
      </div>

      <div class="form-group w-100">
        <label for="telefone">Telefone</label>
        <input type="text" class="form-control" value="<?= @$res[0]['ctt_contact']?>" name="ctt_contact"
          placeholder="(00) 00000-0000">
      </div>

    </div>

    <div class="d-flex p-2 text-white gap-2 w-100 align-itens-center justify-content-center">

      <div class="form-group w-100">
        <label for="sexo">Sexo</label>
        <select name="ctt_sex" class="form-select form-select-sm custom-select" id="sexo">
          <option value="m" <?php echo (@$res[0]["ctt_sex"] == "m") ? "selected" : ""; ?>>M</option>
          <option value="f" <?php echo (@$res[0]["ctt_sex"] == "f") ? "selected" : ""; ?>>F</option>
          <option value="o" <?php echo (@$res[0]["ctt_sex"] == "o") ? "selected" : ""; ?>>O</option>
        </select>
      </div>

      <div class="form-group w-100">
        <label for="datanasc">Data de Nascimento</label>
        <input type="date" class="form-control" value="<?= date('Y-m-d', strtotime(@$res[0]['ctt_date_born'])) ?>"
          name="ctt_date_born" id="datanasc" placeholder="Data de nascimento">
      </div>

    </div>

    <button type="submit" class="btn btn-success"><?= $ctt_id ? 'Salvar': 'Criar' ?></button>

    <a href="/contacts" class="btn btn-danger">Cancelar</a>


  </form>
</div>