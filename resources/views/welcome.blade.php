<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Notif Browser</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    </head>
    <body>
        <div class="container">
            @yield('content')
        </div>

        <audio id="notifikasi_in">
            <source src="{{ asset('notifikasi.wav') }}" type="audio/mpeg">
        </audio>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/push.js/1.0.8/push.min.js" integrity="sha512-eiqtDDb4GUVCSqOSOTz/s/eiU4B31GrdSb17aPAA4Lv/Cjc8o+hnDvuNkgXhSI5yHuDvYkuojMaQmrB5JB31XQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script>

            let notif_in = document.getElementById('notifikasi_in')

            setInterval(() => {

                // Create an XMLHttpRequest object
                var xhr = new XMLHttpRequest();

                // Configure the request
                xhr.open('GET', '{{ route("user.api") }}', true);

                // Set up a callback function to handle the response
                xhr.onload = function() {
                if (xhr.status === 200) {
                    // Request succeeded
                    var response = xhr.responseText;

                    let res = JSON.parse(response)
                    // Do something with the response data
                    
                    var jumlah = localStorage.getItem('jumlah');
                    
                    if(localStorage.getItem('jumlah') == null)
                    {
                        localStorage.setItem('jumlah', res.jumlah);
                    }

                    if(res.jumlah > parseInt(jumlah))
                    {
                        var promise = Push.create("Pemberitahuan", {
                            // tag: 'pasien',
                            body: `Ada pasien baru ${res.jumlah}`,
                            icon: '{{ asset("notif.png") }}',
                            // timeout: 4000,
                            requireInteraction: true,
                            onClick: function () {
                                window.focus();
                                this.close();
                            }
                        });

                        notif_in.play()

                        // if ('speechSynthesis' in window) {
                        // // Membuat objek SpeechSynthesisUtterance
                        // var utterance = new SpeechSynthesisUtterance();

                        // // Menentukan teks yang akan diubah menjadi suara
                        // utterance.text = 'Hello, world!';

                        // // Menggunakan default voice atau menentukan voice tertentu (opsional)
                        // // utterance.voice = speechSynthesis.getVoices()[0];

                        // // Mengatur kecepatan dan pitch suara (opsional)
                        // // utterance.rate = 1.0; // Kecepatan normal
                        // // utterance.pitch = 1.0; // Pitch normal

                        // // Memulai sintesis suara
                        // speechSynthesis.speak(utterance);
                        // }

                        promise.then(function(notification) {
                            notification.close();
                        });
                        // Push.clear();
                        localStorage.setItem('jumlah', res.jumlah);
                    }

                } else {
                    // Request failed
                    console.log('Error: ' + xhr.status);
                }
                };

                // Send the request
                xhr.send();

                
            }, 3000);
        </script>
    </body>
</html>
