<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
</head>
<body>
<h2>Obras del Presupuesto participativo - Activación de cuenta</h2>

<div>
    Gracias por la creación de su cuenta,
    Para activar su cuenta por favor siga el siguinte link o copie y pegue el link en el navegador.
    <a href="{{ URL::to('register/verify/' . $confirmation_code) }}">{{ URL::to('register/verify/' . $confirmation_code) }}</a>.<br/>

</div>


</body>
</html>