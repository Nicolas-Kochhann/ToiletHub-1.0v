document.getElementById('submitComment').addEventListener("click", function(event) {
        event.preventDefault();

        const comment = document.getElementById('comment').value;
        const bathroomId = document.getElementById('bathroomId').value;
        const userId = document.getElementById('loggedUserId').value;

        fetch(`../../ajax/createReview.php`, {
            method: "POST",
            headers: {"Content-Type": "application/x-www-form-urlencoded"},
            body: `comment=${encodeURIComponent(comment)}&bathroomId=${encodeURIComponent(bathroomId)}&userId=${encodeURIComponent(userId)}`
        })
        .then(response => response.json())
        .then(response => {
            const responseComment = response.comment;
            const respoonseUsername = response.username;
            // Ainda não sei o que fazer em caso de sucesso.
            document.getElementById('comment-container').innerHTML += `
            <div class="posted-comment">
                <strong class="commenter">'.$review->getUser()->getUsername().'</strong>
                <p class="comment-body">'.$review->getComment().'</p>
            </div>`; 
        })
        .catch(error => {
            alert('Sorry! Something went wrong');
        });
});
