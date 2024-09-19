<style>
.float__button {
  position: absolute;
  bottom: 55px;
  right: 25px;
}
</style>

<header>
  <h2 class="text-center text-white">Pagina de contato</h2>
</header>


<a href="contacts/form" class="btn btn-primary border border-ligth float__button">Novo</a>

<div class="container-lg d-flex align-itens-center flex-column gap-2" style="height: 400px;">
  <table class="table table text-center table-bordered table-dark table-striped">
    <thead>
      <tr>
        <th scope="col">info</th>
        <th scope="col">Nome</th>
        <th scope="col">Email</th>
        <th scope="col">Endereço</th>
        <th scope="col">Telefone</th>
        <th scope="col">Sexo</th>
        <th scope="col">Data de Nascimento</th>
        <th scope="col">Ações</th>
      </tr>
    </thead>

    <tbody>

      <?php foreach($current_items as $data): ?>
      <tr>
        <td scope="row"><a href="/contacts/profile-contact?ctt_id=<?= $data["ctt_id"] ?>">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-info-circle"
              viewBox="0 0 16 16">
              <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
              <path
                d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0" />
            </svg>
          </a></td>
        <td scope="row"><?= $data["ctt_name"]?></td>
        <td scope="row"><?= $data["ctt_email"]?></td>
        <td scope="row"><?= $data["ctt_adress"]?></td>
        <td scope="row"><?= $data["ctt_contact"]?></td>
        <td scope="row"><?= $data["ctt_sex"]?></td>
        <td scope="row"><?= date('Y-m-d', strtotime(@$data['ctt_date_born']))?></td>
        <td scope="row" class="d-flex gap-2 align-item-center justify-content-center">
          <a class="bg-dark border border-white px-1 rounded" href="contacts/form?ctt_id=<?=$data["ctt_id"]?>">
            <svg xmlns="http://www.w3.org/2000/svg" width="12" color="yellow" height="12" fill="currentColor"
              class="bi bi-pencil-square" viewBox="0 0 16 16">
              <path
                d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
              <path fill-rule="evenodd"
                d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z" />
            </svg>
          </a>

          <a class="bg-dark border border-white px-1 rounded" href="/contacts/form/.post?ctt_id=<?=$data["ctt_id"]?>">
            <svg xmlns="http://www.w3.org/2000/svg" width="12" color="red" height="12" fill="currentColor"
              class="bi bi-trash" viewBox="0 0 16 16">
              <path
                d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z" />
              <path
                d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z" />
            </svg>
          </a>
        </td>
      </tr>

      <?php endforeach; ?>

    </tbody>

  </table>
  <?php
  echo '<div class="pagination d-flex gap-2">';
if ($current_page > 1) {
    echo '<a href="?page=' . ($current_page - 1) . '">Anterior</a>';
}

for ($page = 1; $page <= $total_pages; $page++) {
    if ($page == $current_page) {
        echo '<strong class="text-white">' . $page . '</strong>';
    } else {
        echo '<a href="contacts?page=' . $page . '">' . $page . '</a>';
    }
}

if ($current_page < $total_pages) {
    echo '<a href="?page=' . ($current_page + 1) . '">Proxima</a>';
}
echo '</div>';
?>