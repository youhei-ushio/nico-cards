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

document.getElementById('play_button').addEventListener('click', () => {
    const room_id = document.querySelector('.board').dataset.room_id;
    const member_id = document.querySelector('.board .play').dataset.member_id;

    const cards = [];
    document.querySelectorAll('.board .play .card').forEach(element => {
        cards.push({
            'suit': element.dataset.suit,
            'number': element.dataset.number,
        });
    });

    axios.post(
        '/game/round/play',
        { room_id: room_id, member_id: member_id, cards: cards }
    ).then(() => {
        location.reload();
    }).catch(error => {
        console.error(error);
    });
});
