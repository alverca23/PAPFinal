const calendarGrid = document.querySelector('.calendar-grid');
const prevMonthBtn = document.querySelector('#prev-month');
const nextMonthBtn = document.querySelector('#next-month');
const monthYear = document.querySelector('#month-year');
let descricaoInput;

let currentDate = new Date();
let eventDescriptions = {};

function renderCalendar() {
  const daysInMonth = new Date(
    currentDate.getFullYear(),
    currentDate.getMonth() + 1,
    0
  ).getDate();

  const firstDayOfMonth = new Date(
    currentDate.getFullYear(),
    currentDate.getMonth(),
    1
  ).getDay();

  calendarGrid.innerHTML = '';

  for (let i = 0; i < firstDayOfMonth; i++) {
    const emptyDay = document.createElement('div');
    emptyDay.classList.add('calendar-day', 'empty');
    calendarGrid.appendChild(emptyDay);
  }

  for (let i = 1; i <= daysInMonth; i++) {
    const calendarDay = document.createElement('div');
    calendarDay.classList.add('calendar-day');
    calendarDay.textContent = i;
    calendarGrid.appendChild(calendarDay);

    if (
      currentDate.getDate() === i &&
      currentDate.getMonth() === new Date().getMonth() &&
      currentDate.getFullYear() === new Date().getFullYear()
    ) {
      calendarDay.classList.add('active');
    }

    calendarDay.addEventListener('click', () => {
      const activeDay = document.querySelector('.calendar-day.active');
      if (activeDay) {
        activeDay.classList.remove('active');
      }
      calendarDay.classList.add('active');

      const day = calendarDay.textContent;
      const month = currentDate.getMonth() + 1;
      const year = currentDate.getFullYear();

      if (eventDescriptions.hasOwnProperty(day)) {
        descricaoInput.value = eventDescriptions[day].event;
      } else {
        getEventDescription(year, month, day)
          .then((event) => {
            eventDescriptions[day] = event;
            descricaoInput.value = event.event;
          })
          .catch((error) => {
            console.error('Erro ao obter a descrição do evento:', error);
            descricaoInput.value = 'Nenhum evento encontrado para este dia.';
          });                  
      }
    });
  }

  calendarGrid.addEventListener('click', (event) => {
    if (!event.target.classList.contains('calendar-day')) {
      const activeDay = document.querySelector('.calendar-day.active');
      if (activeDay) {
        activeDay.classList.remove('active');
      }
    }
  });

  monthYear.textContent = currentDate.toLocaleString('default', {
    month: 'long',
    year: 'numeric',
  });

  descricaoInput = document.querySelector('#descricao'); // Atualização: Obter o elemento descricaoInput
}

function getEventDescription(year, month, day) {
  const date = `${year}-${month}-${day}`;

  // Faça a chamada fetch para obter os eventos com base na data
  return fetch(`http://127.0.0.1:8000/DyGym/getDescriptions?date=${date}`, {
    method: 'GET',
    headers: {
      Accept: 'application/json',
      Authorization: `Bearer ${localStorage.getItem('token')}`,
    },
  })
    .then((response) => response.json())
    .then((data) => {
      const event = data.find((event) => event.date === date); // Atualização: Encontre o evento correspondente à data específica
      if (event) {
        return event;
      } else {
        return { event: 'Nenhum evento encontrado para este dia.' }; // Atualização: Mensagem para nenhum evento encontrado
      }
    })
    .catch((error) => {
      throw new Error('Erro ao obter a descrição do evento.');
    });
}

function getUserEvents() {
  // Obtenha o ID do usuário logado do localStorage
  const userID = localStorage.getItem('user_id');

  fetch(`http://127.0.0.1:8000/DyGym/getEvents`, {
    method: 'get',
    headers: {
      Accept: 'application/json',
      Authorization: `Bearer ${localStorage.getItem('token')}`,
    },
  })
    .then((response) => response.json())
    .then((events) => {
      eventDescriptions = {}; // Limpar as descrições de eventos antes de preencher com os eventos do usuário
      events.forEach((event) => {
        const eventDate = new Date(
          event.date.replace(/(\d+)\/(\d+)\/(\d+)/, '$2/$1/$3')
        );
        const day = eventDate.getDate();
        const month = eventDate.getMonth();
        const year = eventDate.getFullYear();

        // Verifique se o evento pertence ao mês atual
        if (
          month === currentDate.getMonth() &&
          year === currentDate.getFullYear()
        ) {
          eventDescriptions[day] = event;
        }
      });
      highlightEventDays(events);
    })
    .catch((error) => {
      console.error('Erro ao obter os eventos:', error);
    });
}

function highlightEventDays(events) {
  const calendarDays = document.querySelectorAll('.calendar-day');

  // Percorra os dias do calendário
  calendarDays.forEach((day) => {
    const dayNumber = parseInt(day.textContent);

    // Verifique se o dia tem um evento associado
    const hasEvent = events.some((event) => {
      const eventDate = new Date(
        event.date.replace(/(\d+)\/(\d+)\/(\d+)/, '$2/$1/$3')
      );
      return (
        eventDate.getDate() === dayNumber &&
        eventDate.getMonth() === currentDate.getMonth() &&
        eventDate.getFullYear() === currentDate.getFullYear()
      );
    });

    // Se o dia tiver um evento, adicione uma classe para destacá-lo
    if (hasEvent) {
      day.classList.add('event-day');
    } else {
      day.classList.remove('event-day');
    }
  });
}

renderCalendar();
getUserEvents();

prevMonthBtn.addEventListener('click', () => {
  currentDate.setMonth(currentDate.getMonth() - 1);
  renderCalendar();
  getUserEvents();
});

nextMonthBtn.addEventListener('click', () => {
  currentDate.setMonth(currentDate.getMonth() + 1);
  renderCalendar();
  getUserEvents();
});
