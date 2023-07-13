function show() {
  var token = localStorage.getItem("token");
  var userId = localStorage.getItem("user_id"); // obtém o ID do usuário armazenado no localStorage
  console.log(localStorage);
  fetch(`http://127.0.0.1:8000/DyGym/show/${userId}`, {
    method: 'get',
    headers: {
      'Accept': 'application/json',
      'Content-Type': 'application/json',
      'Authorization': 'Bearer ' + token
    }
  })
    .then(response => response.json())
    .then(data => {
      // Preencher os campos de formulário com as informações do usuário atual
      document.getElementById('name').value = data.name;
      document.getElementById('email').value = data.email;
      document.getElementById('weight').value = data.weight;
      document.getElementById('height').value = data.height;
      document.getElementById('birthday').value = data.birthday;
    })
    .catch(error => console.error(error));
}

function update() {
  var name = document.getElementById('name').value;
  var email = document.getElementById('email').value;
  var weight = document.getElementById('weight').value;
  var height = document.getElementById('height').value;

  try {
    fetch('http://127.0.0.1:8000/DyGym/infos', {
      method: 'PUT',
      body: JSON.stringify({
        name: name,
        email: email,
        weight: weight,
        height: height,
      }),
      headers: {
        'Content-type': 'application/json; charset=UTF-8',
        'Authorization': 'Bearer ' + localStorage.getItem("token"),

      }
    })
      .then(response => response.json())
      .then(json => {
        checkInfo(json);
      });
  } catch (e) {
    console.log(e);
  }
}

function checkInfo(json) {
  // Lógica para tratar a resposta da solicitação de atualização de informações
  console.log(json);
}

document.addEventListener('DOMContentLoaded', function () {
  const submitButton = document.getElementById('submit-button');

  // Adicionar evento de clique ao botão "Enviar"
  submitButton.addEventListener('click', function (event) {
    event.preventDefault(); // Impedir o envio do formulário

    update(); // Chamar a função update()
  });
});
