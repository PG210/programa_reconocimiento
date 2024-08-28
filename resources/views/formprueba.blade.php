<form action="/send-mail" method="POST">
    @csrf
    <input type="text" name="subject" placeholder="Subject" required>
    <textarea name="content" placeholder="Content" required></textarea>
    <input type="email" name="recipient" placeholder="Recipient Email" required>
    <button type="submit">Send Email</button>
</form>