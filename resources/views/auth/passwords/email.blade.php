<form action="{{ route('password.email') }}" method="POST">
    @csrf
    <div>
        <label for="email">Enter your email address</label>
        <input type="email" name="email" required>
    </div>
    <button type="submit">Send reset link</button>
</form>
