<form action="{{ route('password.update') }}" method="POST">
    @csrf
    <div>
        <label for="verification_code">Enter the verification code</label>
        <input type="text" name="verification_code" required>
    </div>
    <button type="submit">Submit</button>
</form>
