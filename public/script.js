document.addEventListener('DOMContentLoaded', () => {

    const lista = document.querySelector('.versoes ul');
    const modeloItem = lista.querySelector('li'); // 👈 modelo

    function renderizarPolitica(data) {
        if (!data || !data.topicos) return;

        document.querySelector('.titulo').innerText = data.titulo;
        document.getElementById('versao-recente').innerText = "v" + data.versao;
        document.getElementById('data-atualizacao').innerText = data.data_atualizacao;

        const container = document.getElementById('politica');
        container.innerHTML = '';

        // 🔥 NAV
        const nav = document.querySelector('nav ul');
        const modeloNav = document.querySelector('.modelo-topico').cloneNode(true);

        nav.innerHTML = '';

        data.topicos.forEach((item, index) => {
            const i = index + 1;

            // ===== CONTEÚDO =====
            const h3 = document.createElement('h3');
            h3.id = `titulo-topico-${i}`;
            h3.innerText = item.topico;

            const p = document.createElement('p');
            p.innerText = item.conteudo;

            container.appendChild(h3);
            container.appendChild(p);

            // ===== NAV (CLONE) =====
            const clone = modeloNav.cloneNode(true);
            const link = clone.querySelector('a');

            link.innerText = item.topico;
            link.href = `#titulo-topico-${i}`;

            nav.appendChild(clone);
        });
    }

    function carregarPolitica(versao = null) {
        let url = '/app/Controllers/getPolitica.php';

        if (versao) {
            url += '?versao=' + versao;
        }

        fetch(url)
            .then(res => res.json())
            .then(data => renderizarPolitica(data))
            .catch(err => console.error(err));
    }

    function carregarHistorico() {
        fetch('/app/Controllers/getPolitica.php?historico=1')
            .then(res => res.json())
            .then(versoes => {

                lista.innerHTML = ''; // limpa lista

                versoes.forEach((v, index) => {

                    const clone = modeloItem.cloneNode(true);

                    const link = clone.querySelector('a');
                    const spanVersao = clone.querySelector('.versao');
                    const spanAno = clone.querySelector('.ano');

                    // 🔥 injeta dados
                    spanVersao.innerText = "V." + v.versao;
                    spanAno.innerText = new Date(v.data_publicacao).getFullYear();

                    link.dataset.versao = v.versao;

                    link.addEventListener('click', (e) => {
                        e.preventDefault();
                        carregarPolitica(v.versao);
                    });

                    lista.appendChild(clone);

                    // 🔥 carrega a mais recente automaticamente
                    if (index === 0) {
                        carregarPolitica(v.versao);
                    }
                });

            })
            .catch(err => console.error(err));
    }

    carregarHistorico();

});