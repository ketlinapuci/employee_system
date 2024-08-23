
<div class="container">
    <h3>Chat with {{ $chatUser->name }}</h3>
    <div id="chat-box" style="height: 300px; overflow-y: scroll; border: 1px solid #ccc; padding: 10px;">
        @foreach($messages as $message)
            <div>
                <strong>{{ $message->sender_id == Auth::id() ? 'You' : $chatUser->name }}:</strong>
                {{ $message->message }}
            </div>
        @endforeach
    </div>
    <form id="chat-form">
        @csrf
        <input type="hidden" id="receiver_id" name="receiver_id" value="{{ $chatUser->id }}">
        <input type="text" id="message" name="message" placeholder="Type your message..." class="form-control">
        <button type="submit" class="btn btn-primary mt-2">Send</button>
    </form>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
    function fetchMessages() {
        let userId = $('#receiver_id').val();
        $.ajax({
            url: '/chat/messages/' + userId,
            method: 'GET',
            success: function(data) {
                $('#chat-box').empty();
                data.forEach(function(message) {
                    $('#chat-box').append('<div><strong>' + 
                        (message.sender_id == {{ Auth::id() }} ? 'You' : '{{ $chatUser->name }}') + 
                        ':</strong> ' + message.message + '</div>');
                });
            }
        });
    }

    $('#chat-form').on('submit', function(e) {
        e.preventDefault();

        $.ajax({
            url: '{{ route('chat.send') }}',
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                $('#message').val('');
                fetchMessages();
            }
        });
    });

    setInterval(fetchMessages, 1000);
</script>
