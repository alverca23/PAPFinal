function objetiv() {

  var peso_meta = document.getElementById("peso").value;
  var supino = document.getElementById("supino").value;
  var agachamento = document.getElementById("agachamento").value;
  var levantamento = document.getElementById("levantamento").value;
  var date = document.getElementById("date").value;


  try {
    fetch('http://127.0.0.1:8000/DyGym/objetiv', {
      method: 'PUT',
      body: JSON.stringify({
        peso_meta: peso_meta,
        supino: supino,
        agachamento: agachamento,
        levantamento: levantamento,
        date: date,
      }),
      headers: {
        'Content-type': 'application/json; charset=UTF-8',
        'Authorization': 'Bearer ' + localStorage.getItem("token"),

      }
    })
      .then(response => response.json())
      .then(json => {
        // Lógica para tratar a resposta da solicitação de atualização do objetivo
        console.log(json);
      });
  } catch (e) {
    console.log(e);
  }
}

function show() {
  var token = localStorage.getItem("token");
  var userId = localStorage.getItem("user_id"); // obtém o ID do usuário armazenado no localStorage
  console.log(localStorage);
  fetch(`http://127.0.0.1:8000/DyGym/getObjetiv`, {
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
      document.getElementById('peso').value = data.peso_meta;
      document.getElementById('supino').value = data.supino;
      document.getElementById('agachamento').value = data.agachamento;
      document.getElementById('levantamento').value = data.levantamento;
      document.getElementById('date').value = data.date;
    })
    .catch(error => console.error(error));
}
