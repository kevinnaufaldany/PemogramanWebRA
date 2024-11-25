document.getElementById('registrationForm').addEventListener('submit', function (e) {
   const fileInput = document.getElementById('file');
   const file = fileInput.files[0];

   if (file) {
       // Validasi ukuran file
       if (file.size > 2 * 1024 * 1024) { // 2MB
           e.preventDefault();
           alert('Ukuran file terlalu besar. Maksimal 2MB.');
       }

       // Validasi tipe file
       if (file.type !== 'text/plain') {
           e.preventDefault();
           alert('File harus berupa teks (.txt).');
       }
   }
});
