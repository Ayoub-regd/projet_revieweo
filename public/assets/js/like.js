/* Like / unlike en AJAX : pas de rechargement de page (fetch + JSON). */
(function () {
    function majBouton(btn, liked) {
        btn.dataset.liked = liked ? '1' : '0';
        btn.setAttribute('aria-pressed', liked ? 'true' : 'false');
        var label = btn.querySelector('.like-label');
        if (label) {
            label.textContent = liked ? 'Retirer le like' : 'Liker';
        }
    }

    document.querySelectorAll('.btn-like').forEach(function (btn) {
        btn.addEventListener('click', function () {
            var id = btn.getAttribute('data-review-id');
            if (!id) {
                return;
            }

            var body = 'review_id=' + encodeURIComponent(id);

            fetch('index.php?url=like/toggle', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: body,
                credentials: 'same-origin'
            })
                .then(function (res) {
                    return res.json().then(function (data) {
                        return { ok: res.ok, status: res.status, data: data };
                    });
                })
                .then(function (r) {
                    if (r.status === 401) {
                        window.location.href = 'index.php?url=auth/login';
                        return;
                    }
                    if (!r.ok || !r.data || r.data.ok === false) {
                        var m = r.data && r.data.message ? r.data.message : 'Erreur.';
                        alert(m);
                        return;
                    }
                    majBouton(btn, !!r.data.liked);
                    var c = document.querySelector('.like-count');
                    if (c && typeof r.data.count !== 'undefined') {
                        c.textContent = String(r.data.count);
                    }
                })
                .catch(function () {
                    alert('Erreur reseau.');
                });
        });
    });
})();
