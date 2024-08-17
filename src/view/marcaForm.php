<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Formulário de marcas</title>
</head>
<body>
  <fieldset>
    <legend>Formulário de cadastro de marcas</legend>
    <form action="<?=$acao?>" method="POST">
      <label for="">Nome:</label>
      <input type="text" name="nome">
      <input type="submit" value="Salvar">
    </form>
  </fieldset>
</body>
</html>