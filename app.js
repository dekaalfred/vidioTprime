// --- GANTI DENGAN KONFIGURASI FIREBASE PUNYAMU ---
const firebaseConfig = {
    apiKey: "YOUR_API_KEY",
    authDomain: "YOUR_PROJECT_ID.firebaseapp.com",
    projectId: "YOUR_PROJECT_ID",
    storageBucket: "YOUR_PROJECT_ID.appspot.com",
    messagingSenderId: "YOUR_MESSAGING_SENDER_ID",
    appId: "YOUR_APP_ID"
};

// Inisialisasi Firebase
firebase.initializeApp(firebaseConfig);
const auth = firebase.auth();
const db = firebase.firestore();

// Fungsi untuk menampilkan pesan
function showMessage(message, isError = false) {
    const messageEl = document.getElementById("message");
    if (messageEl) {
        messageEl.innerText = message;
        messageEl.style.color = isError ? 'red' : 'green';
    }
}

// LOGIN DENGAN EMAIL DAN PASSWORD
document.getElementById("login-form").addEventListener("submit", async (e) => {
    e.preventDefault();

    const username = document.getElementById("username").value.trim();
    const password = document.getElementById("password").value;

    if (!username || !password) {
        showMessage("Username dan password tidak boleh kosong.", true);
        return;
    }

    try {
        // Check if user exists
        const userQuery = await db.collection('users').where('username', '==', username).get();
        
        if (userQuery.empty) {
            // Create new user
            const userCredential = await auth.createUserWithEmailAndPassword(`${username}@yourapp.com`, password);
            await db.collection('users').doc(userCredential.user.uid).set({
                username: username,
                email: `${username}@yourapp.com`,
                loginMethod: 'email',
                createdAt: firebase.firestore.FieldValue.serverTimestamp(),
                lastLogin: firebase.firestore.FieldValue.serverTimestamp()
            });
            showMessage("Akun berhasil dibuat dan login berhasil!");
        } else {
            // Login existing user
            await auth.signInWithEmailAndPassword(`${username}@yourapp.com`, password);
            // Update last login time
            const user = auth.currentUser;
            await db.collection('users').doc(user.uid).update({
                lastLogin: firebase.firestore.FieldValue.serverTimestamp()
            });
            showMessage("Login berhasil!");
        }
    } catch (error) {
        showMessage(error.message, true);
    }
});

// LOGIN DENGAN GOOGLE
document.getElementById("google-login").addEventListener("click", async () => {
    const provider = new firebase.auth.GoogleAuthProvider();
    
    // Force account selection
    provider.setCustomParameters({
        prompt: 'select_account',
        login_hint: ''
    });
    
    try {
        // Show loading message
        showMessage("Membuka pemilih akun Google...");
        
        const result = await auth.signInWithPopup(provider);
        const user = result.user;
        
        // Check if user exists in Firestore
        const userDoc = await db.collection('users').doc(user.uid).get();
        
        if (!userDoc.exists) {
            // Create new user document
            await db.collection('users').doc(user.uid).set({
                username: user.displayName,
                email: user.email,
                photoURL: user.photoURL,
                loginMethod: 'google',
                createdAt: firebase.firestore.FieldValue.serverTimestamp(),
                lastLogin: firebase.firestore.FieldValue.serverTimestamp()
            });
            showMessage("Akun Google berhasil dibuat dan login berhasil!");
        } else {
            // Update existing user's last login
            await db.collection('users').doc(user.uid).update({
                lastLogin: firebase.firestore.FieldValue.serverTimestamp()
            });
            showMessage("Login dengan Google berhasil!");
        }
        
        // Redirect or update UI after successful login
        console.log("User logged in:", user);
    } catch (error) {
        if (error.code === 'auth/popup-closed-by-user') {
            showMessage("Login dibatalkan oleh pengguna.", true);
        } else {
            showMessage(error.message, true);
        }
    }
});

// Listen for auth state changes
auth.onAuthStateChanged((user) => {
    if (user) {
        console.log("User is signed in:", user);
    } else {
        console.log("User is signed out");
    }
});
