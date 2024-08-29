<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Jubileu Eventos</title>
  <style>
    <?=include 'src/styles/styles.css'?>
  </style>
</head>
<body>
  <header>
    <div class="logo">Jubileu Eventos</div>
    <?=$navContent?>
  </header>
  <main>
    <?=$content?>
  </main>
  <footer style="position:absolute; bottom: 0px">
    &copy; <?=date('Y')?> Eduardo Oliveira & Mateus Algayer.
  </footer>
</body>
</html>
