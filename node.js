// encrypt_gen.js – Run with Node.js
const CryptoJS = require("crypto-js");
const fs = require("fs");

const rawHTML = fs.readFileSync("axis_raw.html", "utf8");
const password = "MySecretKey123";   // 🔐 Change this to your decryption key

const ciphertext = CryptoJS.AES.encrypt(rawHTML, password).toString();
console.log(ciphertext);
// ✅ Copy this output and paste into encrypted_axis.html inside ciphertext variable