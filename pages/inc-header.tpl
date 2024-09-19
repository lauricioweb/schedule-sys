<!DOCTYPE html>

<html>

<head>
  <title>Schedule Sys</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=0.1">
  <link rel="icon" type="image/png" href="/assets/images/favi.png">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="css/index.css">
  <link href="https://cdn.jsdelivr.net/npm/remixicon@4.3.0/fonts/remixicon.css" rel="stylesheet" />


</head>

<body>
  <header
    class="container-fluid py-2 d-flex flex-row justify-content-between align-items-center border-bottom border-ligth bg-dark fixed-top"
    style="display:flex;">
    <div class="w-25">
      <img src="/assets/images/logo.png" class="align-self-start" rounded-circle alt="logo" width="200px"
        style="border-radius:50px;" />

    </div>
    <nav class="navbar navbar-expand-lg navbar-light w-50">
      <form action="" method="POST">
        <div class="d-flex gap-2">
          <input class="form-control w-75" type="search" placeholder="jhon doe" name="texto_pesquisa" />
          <button class="btn border border-ligth btn-dark" type="submit">Pesquisar</button>
        </div>
      </form>
    </nav>

  </header>
  <div class="container__main pt-5 vh-100 pt-1 d-flex align-itens-center">

    <!-- Sidebar -->
    <div class="col-lg-1 h-100  pt-5 bg-dark border border-left border-ligth">
      <div class="sidebar">
        <ul class="nav flex-column">
          <li class="nav-item">
            <a class="nav-link text-white" href="/home">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-white" href="/contacts">Contato</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-white" href="/tasks">Tarefas</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-white" href="/events">Eventos</a>
          </li>
        </ul>
      </div>
    </div>
    <main class="col-lg-11 pt-5 bg-dark  h-100">