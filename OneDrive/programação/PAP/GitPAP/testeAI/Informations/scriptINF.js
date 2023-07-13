
function update() {

  var birthday = document.getElementById("Birthday").value;
  var height = document.getElementById("Height").value;
  var weight = document.getElementById("Weight").value;
  var hobbies = document.getElementById("Hobbies").value;

  try {
    fetch('http://127.0.0.1:8000/DyGym/update', {
      method: 'POST',
      body: JSON.stringify({
        birthday: birthday,
        height: height,
        weight: weight,
        hobbies: hobbies,
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

function checkInfo(res) {
  if (res.message == "CREATED") {
    alert("informações adicionadas com sucesso!");
    window.location.href = "../Main/index.html";
  } else {
    alert("Erro");
  }
}



