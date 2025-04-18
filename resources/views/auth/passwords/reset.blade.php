<form action="{{ route('password.update') }}" method="POST">
    @csrf
    <div>
        <label for="password">New Password</label>
        <input type="password" name="password" required>
    </div>
    <div>
        <label for="password_confirmation">Confirm Password</label>
        <input type="password" name="password_confirmation" required>
    </div>
    <button type="submit">Reset Password</button>
</form>
