<?
function template($title, $body) {
  return '
  <!DOCTYPE html>
  <html lang="ja">
    <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>' . $title . '</title>
    </head>
    <body>' . $body . '</body>
  </html>
  ';
}
?>