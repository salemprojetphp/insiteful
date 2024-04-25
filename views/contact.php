<link rel="stylesheet" href="../public/css/contact.css">
<script src="../public/js/contact.js" defer></script>
<div class="container" id="contact-container">
    <div class="contact-container">
        <div class="content">
            <div class="left-side">
                <div class="address details">
                    <i class="fas fa-map-marker-alt"></i>
                    <div class="topic">Address</div>
                    <div class="text-one">Centre Urbain Nord</div>
                    <div class="text-two">INSAT</div>
                </div>
                <div class="phone details">
                    <i class="fas fa-phone-alt"></i>
                    <div class="topic">Phone</div>
                    <div class="text-one">+216 20 667 149</div>
                    <div class="text-two">+216 52 120 882</div>
                </div>
                <div class="email details">
                    <i class="fas fa-envelope"></i>
                    <div class="topic">Email</div>
                    <div class="text-one">insiteful@gmail.com</div>
                </div>
            </div>
            <div class="right-side">
                <div class="topic-text">Contact Us</div>
                <p>We are pleased to receive any questions from you !</p>
                <form action="/contact/action" method="post">
                    <div class="input-box">
                        <input type="text" id="email-input" name="email" placeholder="Enter your email" required>
                    </div>
                    <div class="input-box">
                        <input type="text" id="object-input" name="object" placeholder="Enter the object" required>
                    </div>
                    <div class="input-box message-box">
                        <textarea name="message" id="message-input"  placeholder="Enter your messsage" required></textarea>
                    </div>
                    <div class="buttons">
                        <a href="/" class="cancel-button" rel="modal:close">Cancel</a>
                        <button type="submit" class="send-button" id="send-button" >Send</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

