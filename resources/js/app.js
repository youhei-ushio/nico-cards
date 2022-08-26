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

document.addEventListener('click', event => {
    if (event.target.id === 'start_button') {
        startRound(event);
    } else if (event.target.id === 'play_button') {
        playCard();
    } else if (event.target.id === 'pass_button') {
        passTurn();
    } else if (event.target.id === 'leave_button') {
        leaveRoom(event);
    }
});

document.querySelectorAll('a.room').forEach(element => {
    element.addEventListener('click', () => {
        loading();
    });
});

const loading = () => {
    document.getElementById('loading').classList.remove('invisible');
}

const polling = () => new Promise((resolve, reject) => {
    const lastEventId = document.getElementById('polling').dataset.last_event_id;
    axios.get(
        `/game/round/polling?last_event_id=${lastEventId}`
    ).then(response => {
        resolve(response.data);
    }).catch(error => {
        reject(error);
    });
});

if (document.getElementById('polling')?.dataset?.last_event_id) {
    setInterval(() => {
        polling()
            .then(proceeded => {
                if (proceeded) {
                    clearTimeout();
                    location.reload();
                }
            })
            .catch(() => {
                clearTimeout();
            });
    }, 1000);
}

const startRound = (event) => {
    const member_id = event.target.dataset.member_id;

    loading();

    axios.post(
        '/game/round/start',
        { member_id: member_id }
    ).then(() => {
        location.reload();
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
        location.reload();
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
        location.reload();
    }).catch(error => {
        console.error(error);
    });
};

const leaveRoom = (event) => {
    const member_id = event.target.dataset.member_id;

    loading();

    axios.get(
        `/lobby/rooms/${member_id}/leave`
    ).then(() => {
        location.reload();
    }).catch(error => {
        console.error(error);
    });
};
