<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New User Register</title>
</head>
<body>
    <h3>Congratulation</h3>
    <br>
    Dear,{{ $user->name}}
    <br>
    Your Account Has Been Created Successfully !
    <br>
    Your Login Detail Are:
    <br>
    <br>
    <strong>UserName:</strong> "<em>{{ $user->email}}</em>"
    <br>
    <strong>Password:</strong> "<em>{{ $password}}</em>"
    <br>
    Plz Update Your Password For Security Reason.......
    <br><br>
    Thanks,From
    <br>
    Admin Panel
    <br>
    Have A Good day

</body>
</html>