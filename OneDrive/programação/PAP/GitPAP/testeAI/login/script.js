function login() {
    alert("Login button pressed");

    var email = document.getElementById("email").value;
    var password = document.getElementById("password").value;

    fetch('http://127.0.0.1:8000/DyGym/login', {
        method: 'post',
        headers: {
            'Accept': 'application/json, text/plain, */*',
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            email: email,
            password: password
        })
    }).then(res => res.json())
        .then(res => {
            checkLogin(res);
    

        } );

}

function checkLogin(res) {
    if (res.token != null) {
      // O login foi bem-sucedido, continuar com o código existente...
      fetch('http://127.0.0.1:8000/DyGym/GetAuthUser', {
        method: 'get',
        headers: {
          'Accept': 'application/json, text/plain, */*',
          'Content-Type': 'application/json',
          'Authorization': `Bearer ${res.token}`
        },
      }).then(res => res.json())
        .then(res => {
          console.log(res.user);
          localStorage.setItem("user_id", res.user.id); // armazena o ID do usuário no localStorage
          checkInfo(); // chama a função para exibir as informações do usuário
        });
  
      console.log(res);
      localStorage.setItem("token", res.token);
    } else {
      // Exibir mensagem de erro
      var errorMessage = document.getElementById('error-message');
      errorMessage.textContent = 'Email ou senha incorretos!.';
  
      // Limpar campos de entrada
      document.getElementById('email').value = '';
      document.getElementById('password').value = '';
  
      // Limpar mensagem de erro após 3 segundos
      setTimeout(function() {
        errorMessage.textContent = '';
      }, 3000);
    }
  }

function checkInfo(){
    var token = localStorage.getItem("token");
    fetch('http://127.0.0.1:8000/DyGym/profile', {
        method: 'get',
        headers: {
            'Accept': 'application/json, text/plain, */*',
            'Content-Type': 'application/json',
            'Authorization': 'Bearer ' + token
        },
    }).then(response => response.json())
        .then(data => {
            if(data.user){     
                if(data.user.birthday == 0 && data.user.height == 0 && data.user.weight == 0 && data.user.hobbies == 0){
                    location.replace("/Informations/InfPer.html");
                } 
                else if(data.user.birthday != 0 && data.user.height != 0 && data.user.weight != 0 && data.user.hobbies != 0){
                    location.replace("/Main/index.html");
                }
            }
        })
        .catch(error => {
            console.log(error);
        });
}

function togglePasswordVisibility() {
    var passwordInput = document.getElementById('password');
    var passwordToggle = document.querySelector('.password-toggle');

    if (passwordInput.type === 'password') {
      passwordInput.type = 'text';
      passwordToggle.src = '/img/eye-off.png';
    } else {
      passwordInput.type = 'password';
      passwordToggle.src = '/img/eye.png';
    }
  }
