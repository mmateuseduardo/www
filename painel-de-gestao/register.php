<?php
// Incluir arquivo de configuração
require_once "</config/config.php";
 
// Defina variáveis e inicialize com valores vazios
$name = $username = $email = $password = $confirm_password = "";
$name_err = $username_err = $email_err = $password_err = $confirm_password_err = "";
 
// Processando dados do formulário quando o formulário é enviado
if($_SERVER["REQUEST_METHOD"] == "POST"){

// Definir o Nome
if(empty(trim($_POST["name"]))){
    $name_err = "Por favor digite seu nome.";
} elseif(!preg_match('/^[a-zA-Z0-9_\ ]+$/', trim($_POST["name"]))){
    $name_err = "O nome de usuário pode conter apenas letras, números e sublinhados.";
} else{
    // Prepare uma declaração selecionada
    $sql = "SELECT id FROM users WHERE name = :name";
    
    if($stmt = $pdo->prepare($sql)){
        // Vincule as variáveis à instrução preparada como parâmetros
        $stmt->bindParam(":name", $param_name, PDO::PARAM_STR);
        
        // Definir parâmetros
        $param_name = trim($_POST["name"]);
        
        // Tente executar a declaração preparada
        if($stmt->execute()){
            if($stmt->rowCount() == 1){
                $name_err = "Este nome de usuário já está em uso.";
            } else{
                $name = trim($_POST["name"]);
            }
        } else{
            echo "Ops! Algo deu errado. Por favor, tente novamente mais tarde.";
        }

        // Fechar declaração
        unset($stmt);
    }
}
    // Validar nome de usuário
    if(empty(trim($_POST["username"]))){
        $username_err = "Por favor coloque um nome de usuário.";
    } elseif(!preg_match('/^[a-zA-Z0-9_.]+$/', trim($_POST["username"]))){
        $username_err = "O nome de usuário pode conter apenas letras, números e sublinhados.";
    } else{
        // Prepare uma declaração selecionada
        $sql = "SELECT id FROM users WHERE username = :username";
        
        if($stmt = $pdo->prepare($sql)){
            // Vincule as variáveis à instrução preparada como parâmetros
            $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);
            
            // Definir parâmetros
            $param_username = trim($_POST["username"]);
            
            // Tente executar a declaração preparada
            if($stmt->execute()){
                if($stmt->rowCount() == 1){
                    $username_err = "Este nome de usuário já está em uso.";
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "Ops! Algo deu errado. Por favor, tente novamente mais tarde.";
            }

            // Fechar declaração
            unset($stmt);
        }
    }

    // Validar email
    if(empty(trim($_POST["email"]))){
        $email_err = "Por favor insira seu e-mail.";
    } elseif(!preg_match('/^[a-zA-Z0-9_.@]+$/', trim($_POST["email"]))){
        $email_err = "O email pode conter apenas letras, números e sublinhados.";
    } else{
        // Prepare uma declaração selecionada
        $sql = "SELECT id FROM users WHERE email = :email";
        
        if($stmt = $pdo->prepare($sql)){
            // Vincule as variáveis à instrução preparada como parâmetros
            $stmt->bindParam(":email", $param_email, PDO::PARAM_STR);
            
            // Definir parâmetros
            $param_email = trim($_POST["email"]);
            
            // Tente executar a declaração preparada
            if($stmt->execute()){
                if($stmt->rowCount() == 1){
                    $email_err = "Este email já está em uso.";
                } else{
                    $email = trim($_POST["email"]);
                }
            } else{
                echo "Ops! Algo deu errado. Por favor, tente novamente mais tarde.";
            }

            // Fechar declaração
            unset($stmt);
        }
    }
    
    // Validar senha
    if(empty(trim($_POST["password"]))){
        $password_err = "Por favor insira uma senha.";     
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "A senha deve ter pelo menos 6 caracteres.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validar e confirmar a senha
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Por favor, confirme a senha.";     
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "A senha não confere.";
        }
    }
    
    // Verifique os erros de entrada antes de inserir no banco de dados
    if(empty ($name_err) && empty ($username_err) && empty ($email_err) && empty($password_err) && empty($confirm_password_err)){
        
        // Prepare uma declaração de inserção
        $sql = "INSERT INTO users (name, username, email, password) VALUES (:name, :username, :email, :password)";
         
        if($stmt = $pdo->prepare($sql)){
            // Vincule as variáveis à instrução preparada como parâmetros
            $stmt->bindParam(":name", $param_name, PDO::PARAM_STR);
            $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);
            $stmt->bindParam(":email", $param_email, PDO::PARAM_STR);
            $stmt->bindParam(":password", $param_password, PDO::PARAM_STR);
            
            // Definir parâmetros
            $param_name = $name;
            $param_username = $username;
            $param_email = $email;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            
            // Tente executar a declaração preparada
            if($stmt->execute()){
                // Redirecionar para a página de login
                header("location: index.php");
            } else{
                echo "Ops! Algo deu errado. Por favor, tente novamente mais tarde.";
            }

            // Fechar declaração
            unset($stmt);
        }
    }
    
    // Fechar conexão
    unset($pdo);
}
?>
 

 <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <div id="register-container">
        <h1>Cadastro</h1>
        <p>Por favor, preencha este formulário para criar uma conta.</p>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <label>Nome</label>
                <input type="text" name="name" class="form-control <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $name; ?>">
                <span class="invalid-feedback"><?php echo $name_err; ?></span>

                <label>Login</label>
                <input type="text" name="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
                <span class="invalid-feedback"><?php echo $username_err; ?></span>

                <label>E-mail</label>
                <input type="text" name="email" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $email; ?>">
                <span class="invalid-feedback"><?php echo $email_err; ?></span>

                <label>Senha</label>
                <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $password; ?>">
                <span class="invalid-feedback"><?php echo $password_err; ?></span>

                <label>Confirme a senha</label>
                <input type="password" name="confirm_password" class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $confirm_password; ?>">
                <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>

                <input type="submit" class="btn btn-primary" value="Criar Conta">
                <input type="reset" class="btn btn-secondary ml-2" value="Apagar Dados">
            <p>Já tem uma conta? <a href="index.php">Entre aqui</a>.</p>
        </form>
    </div>    
</body>
</html>