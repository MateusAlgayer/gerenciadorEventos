<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Marcas</title>
</head>
<body>
  <h1>Marcas</h1>
  <table>
    <th>
      <td>ID</td>
      <td>Nome</td>
    </th>
    <?php
      foreach($listaMarcas as $marca){
        echo "<tr>".
                "<td>".$marca['idMarca']."<td>".
                "<td>".$marca['nome']."<td>".
            "</tr>";
      }
    ?>
  </table>
</body>
</html>