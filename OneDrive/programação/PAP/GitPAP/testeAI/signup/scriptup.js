function register() {

    const textInput = document.getElementById("name");
    const inputValue = textInput.value.trim(); // remove espaços em branco do início e do fim

    // verifica se o valor contém apenas letras
    if (/^[a-zA-Z]+$/.test(inputValue)) {
        // envia o formulário ou faz outra ação aqui
        alert("Valor válido: " + inputValue);
    } else {
        alert("Por favor, insira apenas letras.");
    }
    alert("Register button pressed");

    var name = document.getElementById("name").value;
    var email = document.getElementById("email").value;
    var password = document.getElementById("password").value;


    fetch('http://127.0.0.1:8000/DyGym/register', {
        method: 'post',
        headers: {
            'Accept': 'application/json, text/plain, */*',
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            name: name,
            email: email,
            password: password,
            conta: 'user'

        })
    }).then(res => res.json())
        .then(res => checkRegister(res));

}

function checkRegister(res) {
    try {
        console.log(res);
        if (res.message == "CREATED") {
            alert("Conta criada com sucesso!");
            location.replace("../Login/index.html");
        }
    } catch (err) {
        console.log(err);
    }

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
  


