document.getElementById('submitComment').addEventListener("click", function(event) {
        event.preventDefault();

        const comment = document.getElementById('comment').value;
        const bathroomId = doccument.getElementById('bathroomId').value;
        const userId = document.getElementById('loggedUserId').value;


        // Código Exemplo
        /*
        fetch(`src/controllers/favoritos.php`, {
            method: "POST",
            headers: {"Content-Type": "application/x-www-form-urlencoded"},
            body: `comment=${encodeURIComponent(comment)}&bathroomId=${encodeURIComponent(bathroomId)}&userId=${encodeURIcomponent(userId)}`
        })
        .then(response => response.text())
        .then(response => {
            // Ainda não sei o que fazer em caso de sucesso.
            if (response.toLowerCase() === "sucess"){
                this.textContent = "Remover dos favoritos";
            } else if (response.toLowerCase() === "removido"){
                this.textContent = "Adicionar aos favoritos";
            }
        });
        */
});
