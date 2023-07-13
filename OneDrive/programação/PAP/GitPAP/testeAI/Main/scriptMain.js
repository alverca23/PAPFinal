function name(){

    fetch('http://127.0.0.1:8000/DyGym/login', {
        method: 'post',
        headers: {
            'Accept': 'application/json, text/plain, */*',
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            username: username,
            password: password
        })
    }).then(function(response) {
        return response.text();
      }).then(function(username) {
        var label = document.getElementById("username");
        label.innerHTML = username;
      });
}

  