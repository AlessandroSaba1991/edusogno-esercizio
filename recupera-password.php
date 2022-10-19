<?php
session_start();
include __DIR__ . '/controllers/utenteController.php';
if (isset($_POST['recupero'])) {
    $successfull = UtenteController::resetPassword($_POST['email'], $_POST['password']);
}
include __DIR__ . '/layout/header.php';
?>

<main>
    <?php if ($successfull) : ?>
        <div class="message">
            <p>Password aggiornata, ora puoi eseguire il login <a href="./index.php">QUI</a> </p>
        </div>
    <?php endif; ?>
    <section class="recupero pt-5">
        <h1>Password dimenticata?</h1>
        <div class="container-form">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                <div class="input">
                    <label for="email">Inserisci l'e-mail</label>
                    <input type="mail" placeholder="name@example.com" id="email" name="email" value="<?= $_POST['email'] ?>">
                    <?php if ($response === "Email non esiste") : ?>
                        <div class="error-text">
                            <p><?= $response ?></p>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="input">
                    <label for="password">Inserisci la nuova password</label>
                    <input type="password" name="password" id="password" placeholder="Scrivila qui">
                </div>
                <div class="actions">
                    <button type="submit" name="recupero">RESET PASSWORD</button>
                </div>
            </form>
            <div class="question-link">
                <p>Non hai ancora un profilo? <a href="./registrati.php">Registrati</a></p>
            </div>
        </div>
    </section>
</main>
<?php
include __DIR__ . '/layout/footer.php';
?>