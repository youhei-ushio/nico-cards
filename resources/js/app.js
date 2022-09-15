import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

document.querySelectorAll('.card.playable').forEach(element => {
    element.addEventListener('click', event => {
        if (event.target.parentNode.classList.contains('my-hand')) {
            document.querySelector('.board .play').appendChild(event.target);
        } else {
            document.querySelector('.my-hand').appendChild(event.target);
        }
    });
});

document.getElementById('start_button')?.addEventListener('click', event => {
    startRound(event);
});

document.getElementById('play_button')?.addEventListener('click', () => {
    playCard();
});

document.getElementById('pass_button')?.addEventListener('click', () => {
    passTurn();
});

document.getElementById('leave_button')?.addEventListener('click', event => {
    leaveRoom(event);
});

document.querySelectorAll('#rooms a.room').forEach(element => {
    element.addEventListener('click', (event) => {
        enterRoom(event);
    });
});

const loading = () => {
    document.getElementById('loading').classList.remove('invisible');
}

const enterRoom = (event) => {
    const room_id = event.currentTarget.dataset.room_id;
    const member_id = event.currentTarget.dataset.member_id;

    loading();

    axios.get(`/lobby/rooms/${room_id}/enter?member_id=${member_id}`
    ).then(() => {

    }).catch(error => {
        console.error(error);
    });
};

const leaveRoom = (event) => {
    const room_id = event.currentTarget.dataset.room_id;
    const member_id = event.currentTarget.dataset.member_id;

    loading();

    axios.get(`/lobby/rooms/${room_id}/leave?member_id=${member_id}`
    ).then(() => {

    }).catch(error => {
        console.error(error);
    });
};

const startRound = (event) => {
    const member_id = event.target.dataset.member_id;

    loading();

    axios.post(
        '/game/round/start',
        { member_id: member_id }
    ).then(() => {

    }).catch(error => {
        console.error(error);
    });
};

const playCard = () => {
    const room_id = document.querySelector('.board').dataset.room_id;
    const member_id = document.querySelector('.board .play').dataset.member_id;

    const cards = [];
    document.querySelectorAll('.board .play .card').forEach(element => {
        cards.push({
            'suit': element.dataset.suit,
            'number': element.dataset.number,
        });
    });

    loading();

    axios.post(
        '/game/round/play',
        { room_id: room_id, member_id: member_id, cards: cards }
    ).then(() => {

    }).catch(error => {
        console.error(error);
    });
};

const passTurn = () => {
    const room_id = document.querySelector('.board').dataset.room_id;
    const member_id = document.querySelector('.board .play').dataset.member_id;

    loading();

    axios.post(
        '/game/round/play',
        { room_id: room_id, member_id: member_id }
    ).then(() => {

    }).catch(error => {
        console.error(error);
    });
};
