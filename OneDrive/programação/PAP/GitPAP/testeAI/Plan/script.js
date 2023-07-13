document.addEventListener('DOMContentLoaded', function() {
  // Obtém o plano de treino do usuário logado
  fetch('http://127.0.0.1:8000/DyGym/getExercisesForLoggedInUser', {
    method: 'GET',
    headers: {
      'Content-Type': 'application/json',
      'Authorization': `Bearer ${localStorage.getItem('token')}`
    }
  })
    .then(response => response.json())
    .then(data => {
      if (data.exercises.length > 0) {
        // Exibe os exercícios do plano de treino na página
        data.exercises.forEach(exercise => {
          const exerciseCard = createExerciseCard(exercise);
          document.getElementById('exercise-container').appendChild(exerciseCard);
        });
      } else {
        // Caso não haja exercícios no plano de treino
        const noExercisesMessage = document.createElement('p');
        noExercisesMessage.textContent = 'Nenhum exercício encontrado no plano de treino.';
        document.getElementById('exercise-container').appendChild(noExercisesMessage);
      }
    })
    .catch(error => {
      console.error('Erro ao obter os exercícios do plano de treino:', error);
    });

  // Função para criar a div do exercício
  function createExerciseCard(exercise) {
    const exerciseCard = document.createElement('div');
    exerciseCard.classList.add('exercise-card');

    const exerciseImage = document.createElement('div');
    exerciseImage.classList.add('exercise-image');

    const exerciseImg = document.createElement('img');
    exerciseImg.src = exercise.Ficheiro;

    exerciseImg.addEventListener('click', function() {
      exerciseImg.classList.toggle('zoomed');
    });

    exerciseImage.appendChild(exerciseImg);
    exerciseCard.appendChild(exerciseImage);
  
    const exerciseInfo = document.createElement('div');
    exerciseInfo.classList.add('exercise-info');

    const exerciseSection = document.createElement('p');
    exerciseSection.classList.add('exercise-section');
    exerciseSection.textContent = exercise.Section;

    exerciseInfo.appendChild(exerciseSection);

    const exerciseName = document.createElement('h3');
    exerciseName.classList.add('exercise-name');
    exerciseName.textContent = exercise.Name;

    exerciseInfo.appendChild(exerciseName);

    const exerciseRepsSets = document.createElement('p');
    exerciseRepsSets.classList.add('exercise-reps-sets');
    exerciseRepsSets.textContent = `Repetições: ${exercise.Reps} | Séries: ${exercise.Sets}`;
    exerciseInfo.appendChild(exerciseRepsSets);
    exerciseCard.appendChild(exerciseInfo);
  
    return exerciseCard;
  }
});
