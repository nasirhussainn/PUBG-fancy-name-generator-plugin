<?php
/*
Plugin Name: Fancy PUBG Name Generator
Description: Generates a single fancy PUBG name with stylish characters using a shortcode.
Version:     1.1    
Author:      @nasir2008
License:     GPLv2 or later
*/

// Register shortcode for the name generator
function pubg_name_generator_shortcode() {
    ob_start();
    ?>

    <style>
    .name-container {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    margin-bottom: 10px;
}

#name-box {
    display: flex; /* Added */
    align-items: center; /* Added */
    position: relative;
    width: 50%;
    height: 50px;
    border: 1.5px solid #000;
    text-align: center;
    overflow: hidden;
    border-radius: 12px;
    
    
}

.name-box input[type="text"] {
    flex: 1; /* Added */
    height: 100%; /* Updated */
    opacity: 0;
    cursor: pointer;
    font-size: large;
}

.copy-button {
    padding: 5px;
    background-color: #f2f2f2;
    border: none;
    font-size: 24px;
    cursor: pointer;
    margin-right: 5%;
    border-radius: 12px;
    border: 1px solid black;
}
.copy-button:hover{
    background-color: aqua;
    color: aliceblue;
}

    </style> 
  

    <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" onsubmit="event.preventDefault(); generatePubgNames();">
    <input type="hidden" name="action" value="generate_pubg_names">
    <label for="name">Enter your name:</label>
    <input type="text" name="name" id="name" required>
    <input type="submit" value="Generate">
    <?php wp_nonce_field('pubg_name_generator_nonce', 'pubg_name_generator_nonce'); ?>
    </form>
    <div id="outputContainer"></div>
    <script>
    function generatePubgNames() {
        var name = document.getElementById("name").value;

        // Create a new XMLHttpRequest object
        var xhr = new XMLHttpRequest();

        // Set up the request
        xhr.open("POST", "<?php echo esc_url(admin_url('admin-post.php')); ?>", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        // Set up the callback function
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                var response = xhr.responseText;
                document.getElementById("outputContainer").innerHTML = response;
            }
        };

        // Send the request
        xhr.send("action=generate_pubg_names&name=" + encodeURIComponent(name) + "&pubg_name_generator_nonce=" + encodeURIComponent("<?php echo wp_create_nonce('pubg_name_generator_nonce'); ?>"));
    }
    </script>
  


    <?php
    return ob_get_clean();
}
add_shortcode('pubg_name_generator', 'pubg_name_generator_shortcode');
add_action('admin_post_generate_pubg_names', 'generate_pubg_names');
add_action('admin_post_nopriv_generate_pubg_names', 'generate_pubg_names');

// Handle form submission and generate fancy PUBG name
function generate_pubg_names() {
    if (isset($_POST['name'])) {
        if (!wp_verify_nonce($_POST['pubg_name_generator_nonce'], 'pubg_name_generator_nonce')) {
            wp_die('Invalid nonce');
        }

        $inputName = sanitize_text_field($_POST['name']);
        $stylishNames = generate_pubg_name($inputName);

        ob_start(); // Start output buffering
        echo '<h4>Fancy PUBG Names:</h4>';
        $last=25;
        for ($i = 0; $i < $last; $i++) {
            if (!empty($stylishNames[$i])) {
                echo '<input id="name-box" type="text" value="' . $stylishNames[$i] . '" readonly>';
                echo '<button class="copy-button" onclick="copyText(this)">Copy</button>';
                if( ($i)%2!=0 ){
                echo '<br>';}
            
            }
        }
        $output = ob_get_clean(); // Get the buffered output

        echo $output; // Send the output to the browser
    }
}
?>

<script>
    function copyText(button) {
        var input = button.previousElementSibling;
        input.select();
        input.setSelectionRange(0, 99999); // For mobile devices
        document.execCommand("copy");
    }
</script>

<?php

add_action('admin_post_generate_pubg_names', 'generate_pubg_names');
add_action('admin_post_nopriv_generate_pubg_names', 'generate_pubg_names');

// Function to generate a single fancy PUBG name
function generate_pubg_name($name) {
    // Array of fancy character mappings
    $fancyCharacters1 = array('A' => 'ค', 'B' => '๖', 'C' => 'ς', 'D' => '๔', 'E' => 'є','F' => 'Ŧ', 'G' => '๛', 'H' => 'ђ', 'I' => 'เ', 'J' => 'ן', 'K' => 'к', 'L' => 'ɭ', 'M' => '๓', 'N' => 'ภ', 'O' => '๏', 'P' => 'ק', 'Q' => 'ợ', 'R' => 'г', 'S' => 'ร', 'T' => 'Շ', 'U' => 'ย', 'V' => 'ש', 'W' => 'ฬ', 'X' => 'א', 'Y' => 'ץ','Z' => 'չ',);

    $fancyCharacters2 = array('A'=> '𝔄', 'B'=> '𝔅', 'C'=> 'ℭ','D'=> '𝔇','E'=> '𝔈','F'=> '𝔉','G'=> '𝔊','H'=> 'ℌ', 'I'=>'ℑ','J'=> '𝔍','K'=> '𝔎','L'=> '𝔏','M'=> '𝔐','N'=> '𝔑','O'=> '𝔒','P'=> '𝔓','Q'=> '𝔔','R'=> 'ℜ','S'=> '𝔖','T'=> '𝔗','U'=> '𝔘','V'=> '𝔙','W'=> '𝔚','X'=> '𝔛','Y'=> '𝔜','Z'=> 'ℨ',    );

    $fancyCharacters3 = array('A' => '𝕬', 'B' => '𝕭', 'C' => '𝕮', 'D' => '𝕯', 'E' => '𝕰', 'F' => '𝕱', 'G' => '𝕲', 'H' => '𝕳', 'I' => '𝕴', 'J' => '𝕵', 'K' => '𝕶', 'L' => '𝕷', 'M' => '𝕸', 'N' => '𝕹', 'O' => '𝕺', 'P' => '𝕻', 'Q' => '𝕼', 'R' => '𝕽', 'S' => '𝕾', 'T' => '𝕿', 'U' => '𝖀', 'V' => '𝖁', 'W' => '𝖂', 'X' => '𝖃', 'Y' => '𝖄', 'Z' => '𝖅');

    $fancyCharacters4 = array('A' => '𝔸', 'B' => '𝔹', 'C' => 'ℂ', 'D' => '𝔻', 'E' => '𝔼', 'F' => '𝔽', 'G' => '𝔾', 'H' => 'ℍ', 'I' => '𝕀', 'J' => '𝕁', 'K' => '𝕂', 'L' => '𝕃', 'M' => '𝕄', 'N' => 'ℕ', 'O' => '𝕆', 'P' => 'ℙ', 'Q' => 'ℚ', 'R' => 'ℝ', 'S' => '𝕊', 'T' => '𝕋', 'U' => '𝕌', 'V' => '𝕍', 'W' => '𝕎', 'X' => '𝕏', 'Y' => '𝕐', 'Z' => 'ℤ');
    
    $fancyCharacters5 = array('A' => 'Ａ', 'B' => 'Ｂ', 'C' => 'Ｃ', 'D' => 'Ｄ', 'E' => 'Ｅ', 'F' => 'Ｆ', 'G' => 'Ｇ', 'H' => 'Ｈ', 'I' => 'Ｉ', 'J' => 'Ｊ', 'K' => 'Ｋ', 'L' => 'Ｌ', 'M' => 'Ｍ', 'N' => 'Ｎ', 'O' => 'Ｏ', 'P' => 'Ｐ', 'Q' => 'Ｑ', 'R' => 'Ｒ', 'S' => 'Ｓ', 'T' => 'Ｔ', 'U' => 'Ｕ', 'V' => 'Ｖ', 'W' => 'Ｗ', 'X' => 'Ｘ', 'Y' => 'Ｙ', 'Z' => 'Ｚ');

    $fancyCharacters6 = array('A' => '𝒜', 'B' => '𝐵', 'C' => '𝒞', 'D' => '𝒟', 'E' => '𝐸', 'F' => '𝐹', 'G' => '𝒢', 'H' => '𝐻', 'I' => '𝐼', 'J' => '𝒥', 'K' => '𝒦', 'L' => '𝐿', 'M' => '𝑀', 'N' => '𝒩', 'O' => '💍', 'P' => '𝒫', 'Q' => '𝒬', 'R' => '𝑅', 'S' => '𝒮', 'T' => '𝒯', 'U' => '𝒰', 'V' => '𝒱', 'W' => '𝒲', 'X' => '𝒳', 'Y' => '𝒴', 'Z' => '𝒵');

    $fancyCharacters7 = array('A' => 'ᴀ', 'B' => 'ʙ', 'C' => 'ᴄ', 'D' => 'ᴅ', 'E' => 'ᴇ', 'F' => 'ꜰ', 'G' => 'ɢ', 'H' => 'ʜ', 'I' => 'ɪ', 'J' => 'ᴊ', 'K' => 'ᴋ', 'L' => 'ʟ', 'M' => 'ᴍ', 'N' => 'ɴ', 'O' => 'ᴏ', 'P' => 'ᴘ', 'Q' => 'Q', 'R' => 'ʀ', 'S' => 'ꜱ', 'T' => 'ᴛ', 'U' => 'ᴜ', 'V' => 'ᴠ', 'W' => 'ᴡ', 'X' => 'x', 'Y' => 'ʏ', 'Z' => 'ᴢ');

    $fancyCharacters8 = array('A' => 'A̷', 'B' => 'B̷', 'C' => 'C̷', 'D' => 'D̷', 'E' => 'E̷', 'F' => 'F̷', 'G' => 'G̷', 'H' => 'H̷', 'I' => 'I̷', 'J' => 'J̷', 'K' => 'K̷', 'L' => 'L̷', 'M' => 'M̷', 'N' => 'N̷', 'O' => 'O̷', 'P' => 'P̷', 'Q' => 'Q̷', 'R' => 'R̷', 'S' => 'S̷', 'T' => 'T̷', 'U' => 'U̷', 'V' => 'V̷', 'W' => 'W̷', 'X' => 'X̷', 'Y' => 'Y̷', 'Z' => 'Z̷');

    $fancyCharacters9 = array('A' => 'A̲', 'B' => 'B̲', 'C' => 'C̲', 'D' => 'D̲', 'E' => 'E̲', 'F' => 'F̲', 'G' => 'G̲', 'H' => 'H̲', 'I' => 'I̲', 'J' => 'J̲', 'K' => 'K̲', 'L' => 'L̲', 'M' => 'M̲', 'N' => 'N̲', 'O' => 'O̲', 'P' => 'P̲', 'Q' => 'Q̲', 'R' => 'R̲', 'S' => 'S̲', 'T' => 'T̲', 'U' => 'U̲', 'V' => 'V̲', 'W' => 'W̲', 'X' => 'X̲', 'Y' => 'Y̲', 'Z' => 'Z̲');

    $fancyCharacters10 = array('A' => 'α', 'B' => '𝓫', 'C' => 'c', 'D' => 'ᗪ', 'E' => '𝒆', 'F' => 'ｆ', 'G' => 'Ⓖ', 'H' => '𝓗', 'I' => 'Į', 'J' => 'נ', 'K' => '𝓚', 'L' => 'ˡ', 'M' => 'Μ', 'N' => 'ή', 'O' => 'σ', 'P' => 'ℙ', 'Q' => 'Ǫ', 'R' => '𝐫', 'S' => '𝕊', 'T' => 'Ⓣ', 'U' => 'ｕ', 'V' => 'ν', 'W' => '𝐰', 'X' => 'Ｘ', 'Y' => '𝓎', 'Z' => '𝔷');

    $fancyCharacters11 = array('A' => '𝓐', 'B' => '𝓑', 'C' => '𝓒', 'D' => '𝓓', 'E' => '𝓔', 'F' => '𝓕', 'G' => '𝓖', 'H' => '𝓗', 'I' => '𝓘', 'J' => '𝓙', 'K' => '𝓚', 'L' => '𝓛', 'M' => '𝓜', 'N' => '𝓝', 'O' => '𝓞', 'P' => '𝓟', 'Q' => '𝓠', 'R' => '𝓡', 'S' => '𝓢', 'T' => '𝓣', 'U' => '𝓤', 'V' => '𝓥', 'W' => '𝓦', 'X' => '𝓧', 'Y' => '𝓨', 'Z' => '𝓩');

    $fancyCharacters12 = array('A' => '🄰', 'B' => '🄱', 'C' => '🄲', 'D' => '🄳', 'E' => '🄴', 'F' => '🄵', 'G' => '🄶', 'H' => '🄷', 'I' => '🄸', 'J' => '🄹', 'K' => '🄺', 'L' => '🄻', 'M' => '🄼', 'N' => '🄽', 'O' => '🄾', 'P' => '🄿', 'Q' => '🅀', 'R' => '🅁', 'S' => '🅂', 'T' => '🅃', 'U' => '🅄', 'V' => '🅅', 'W' => '🅆', 'X' => '🅇', 'Y' => '🅈', 'Z' => '🅉');

    $fancyCharacters13 = array('A' => 'A̷̧̟̮͔̫̫̥̝̝̳̽͐̄̿̍͊̑̕͠', 'B' => 'B̷̪͌̐͌̀̾͝', 'C' => 'C̵̨̨͉̥̖̮͕͐̃͂̓͝', 'D' => 'Ḑ̷̡̺̫̲͙͍̪̙̒̿́̏̀̀̀̍̔͋͜', 'E' => 'E̸̺͙̹͊̇͐̍̀͘ͅ', 'F' => 'F̵̲̽̿͛̕', 'G' => 'G̷̖̫̪̘͉̯̯͕̿͊̽͑́̓̒͛͌̕͜', 'H' => 'Ḩ̸̬͍̠̬̼̰̦̈́̽̕͘', 'I' => 'Ī̸̢̺', 'J' => 'J̸̻͎̬̠͈͍͆', 'K' => 'K̵̨̼̳͊̾̀̿͐̿', 'L' => 'L̴̼̋͋̄̾̈́̽̏͌̑͝', 'M' => 'M̵̪̼̓̀̈́͠͠', 'N' => 'Ñ̴̠̖͙͆̅̀͛̆̏̌͐̕͜', 'O' => 'Ǫ̶̧͍͖̈́̆̋̕', 'P' => 'P̶̖̥̀͌̔́͊̎̀̎͘', 'Q' => 'Q̶̦͓̺̀̋̎̓̈́͋̐̏͝', 'R' => 'R̴̠̝̼̗͎̀͝', 'S' => 'Ş̴̳͕̤̤̫̭̪̙̿̌͝', 'T' => 'T̷͇̦̩̖̗̗̬͚̗̻͂̇͊̾͂̓', 'U' => 'Ŭ̵͖͍̘̪͍̘͍̋̋̿̀̀͐̀̌͜͜ͅ', 'V' => 'V̷̄̾̊̅̾̉̃ͅ', 'W' => 'W̸̢̛̦͙̗̖̩͔̠̍́̆ͅ', 'X' => 'X̴͈͚̜̲̘͕̫̺̻́̏̓̽̄̋͘͠ͅ', 'Y' => 'Y̴̨̙̼̖̺͍͎͍̮̅̆̑͛͂̉̔̀̑́', 'Z' => 'Z̷̻̖͈̫̰̃');

    $fancyCharacters14 = array('A' => '🅰', 'B' => '🅱', 'C' => '🅲', 'D' => '🅳', 'E' => '🅴', 'F' => '🅵', 'G' => '🅶', 'H' => '🅷', 'I' => '🅸', 'J' => '🅹', 'K' => '🅺', 'L' => '🅻', 'M' => '🅼', 'N' => '🅽', 'O' => '🅾', 'P' => '🅿', 'Q' => '🆀', 'R' => '🆁', 'S' => '🆂', 'T' => '🆃', 'U' => '🆄', 'V' => '🆅', 'W' => '🆆', 'X' => '🆇', 'Y' => '🆈', 'Z' => '🆉');

    $fancyCharacters15 = array('A' => 'ᴀ', 'B' => 'ʙ', 'C' => 'ᴄ', 'D' => 'ᴅ', 'E' => 'ᴇ', 'F' => 'ꜰ', 'G' => 'ɢ', 'H' => 'ʜ', 'I' => 'ɪ', 'J' => 'ᴊ', 'K' => 'ᴋ', 'L' => 'ʟ', 'M' => 'ᴍ', 'N' => 'ɴ', 'O' => 'ᴏ', 'P' => 'ᴘ', 'Q' => 'Q', 'R' => 'ʀ', 'S' => 'ꜱ', 'T' => 'ᴛ', 'U' => 'ᴜ', 'V' => 'ᴠ', 'W' => 'ᴡ', 'X' => 'x', 'Y' => 'ʏ', 'Z' => 'ᴢ');

    $fancyCharacters16 = array('A' => 'ₐ', 'B' => 'B', 'C' => 'C', 'D' => 'D', 'E' => 'ₑ', 'F' => 'F', 'G' => 'G', 'H' => 'ₕ', 'I' => 'ᵢ', 'J' => 'ⱼ', 'K' => 'ₖ', 'L' => 'ₗ', 'M' => 'ₘ', 'N' => 'ₙ', 'O' => 'ₒ', 'P' => 'ₚ', 'Q' => 'Q', 'R' => 'ᵣ', 'S' => 'ₛ', 'T' => 'ₜ', 'U' => 'ᵤ', 'V' => 'ᵥ', 'W' => 'W', 'X' => 'ₓ', 'Y' => 'Y', 'Z' => 'Z');

    $fancyCharacters17 = array('A' => 'Ⱥ', 'B' => 'β', 'C' => '↻', 'D' => 'Ꭰ', 'E' => 'Ɛ', 'F' => 'Ƒ', 'G' => 'Ɠ', 'H' => 'Ƕ', 'I' => 'į', 'J' => 'ل', 'K' => 'Ҡ', 'L' => 'Ꝉ', 'M' => 'Ɱ', 'N' => 'ហ', 'O' => 'ට', 'P' => 'φ', 'Q' => 'Ҩ', 'R' => 'འ', 'S' => 'Ϛ', 'T' => 'Ͳ', 'U' => 'Ա', 'V' => 'Ỽ', 'W' => 'చ', 'X' => 'ჯ', 'Y' => 'Ӌ', 'Z' => 'ɀ');

    $fancyCharacters18 = array('A' => 'ᗩ', 'B' => 'ᗷ', 'C' => 'ᑕ', 'D' => 'ᗪ', 'E' => 'E', 'F' => 'ᖴ', 'G' => 'G', 'H' => 'ᕼ', 'I' => 'I', 'J' => 'ᒍ', 'K' => 'K', 'L' => 'ᒪ', 'M' => 'ᗰ', 'N' => 'ᑎ','O' => 'O', 'P' => 'ᑭ', 'Q' => 'ᑫ', 'R' => 'ᖇ', 'S' => 'ᔕ', 'T' => 'T', 'U' => 'ᑌ', 'V' => 'ᐯ', 'W' => 'ᗯ', 'X' => '᙭', 'Y' => 'Y', 'Z' => 'ᘔ');

    $fancyCharacters19 = array('A' => '⧼A̼⧽', 'B' => '⧼B̼⧽', 'C' => '⧼C̼⧽', 'D' => '⧼D̼⧽', 'E' => '⧼E̼⧽', 'F' => '⧼F̼⧽', 'G' => '⧼G̼⧽', 'H' => '⧼H̼⧽', 'I' => '⧼I̼⧽', 'J' => '⧼J̼⧽', 'K' => '⧼K̼⧽', 'L' => '⧼L̼⧽', 'M' => '⧼M̼⧽', 'N' => '⧼N̼⧽','O' => '⧼O̼⧽', 'P' => '⧼P̼⧽', 'Q' => '⧼Q̼⧽', 'R' => '⧼R̼⧽', 'S' => '⧼S̼⧽', 'T' => '⧼T̼⧽', 'U' => '⧼U̼⧽', 'V' => '⧼V̼⧽', 'W' => '⧼W̼⧽', 'X' => '⧼X̼⧽', 'Y' => '⧼Y̼⧽', 'Z' => '⧼Z̼⧽');

    $fancyCharacters20 = array('A' => 'ᵃ', 'B' => '𝔹', 'C' => 'Č', 'D' => 'ⓓ', 'E' => '乇', 'F' => '𝕗', 'G' => '𝓖', 'H' => 'Ⓗ', 'I' => '𝕚', 'J' => '𝐣', 'K' => '𝓴', 'L' => '𝔩', 'M' => '𝕞', 'N' => 'ℕ','O' => 'Ỗ', 'P' => 'ρ', 'Q' => 'q', 'R' => 'Ⓡ', 'S' => 'Ŝ', 'T' => '𝐭', 'U' => '𝔲', 'V' => '𝔳', 'W' => '𝕎', 'X' => '𝓍', 'Y' => 'ʸ', 'Z' => 'z');

    $fancyCharacters21 = array('A' => '⦏Â⦎', 'B' => '⦏B̂⦎', 'C' => '⦏Ĉ⦎', 'D' => '⦏D̂⦎', 'E' => '⦏Ê⦎', 'F' => '⦏F̂⦎', 'G' => '⦏Ĝ⦎', 'H' => '⦏Ĥ⦎', 'I' => '⦏Î⦎', 'J' => '⦏Ĵ⦎', 'K' => '⦏K̂⦎', 'L' => '⦏L̂⦎', 'M' => '⦏M̂⦎', 'N' => '⦏N̂⦎','O' => '⦏Ô⦎', 'P' => '⦏P̂⦎', 'Q' => '⦏Q̂⦎', 'R' => '⦏R̂⦎', 'S' => '⦏Ŝ⦎', 'T' => '⦏T̂⦎', 'U' => '⦏Û⦎', 'V' => '⦏V̂⦎', 'W' => '⦏Ŵ⦎', 'X' => '⦏X̂⦎', 'Y' => '⦏Ŷ⦎', 'Z' => '⦏Ẑ⦎');

    $fancyCharacters22 = array('A' => '『A』', 'B' => '『B』', 'C' => '『C』', 'D' => '『D』', 'E' => '『E』', 'F' => '『F』', 'G' => '『G』', 'H' => '『H』', 'I' => '『I』', 'J' => '『J』', 'K' => '『K』', 'L' => '『L』', 'M' => '『M』', 'N' => '『N』','O' => '『O』', 'P' => '『P』', 'Q' => '『Q』', 'R' => '『R』', 'S' => '『S』', 'T' => '『T』', 'U' => '『U』', 'V' => '『V』', 'W' => '『W』', 'X' => '『X』', 'Y' => '『Y』', 'Z' => '『Z』');

    $fancyCharacters23 = array('A' => '⨳A⨳', 'B' => '⨳B⨳', 'C' => '⨳C⨳', 'D' => '⨳D⨳', 'E' => '⨳E⨳', 'F' => '⨳F⨳', 'G' => '⨳G⨳', 'H' => '⨳H⨳', 'I' => '⨳I⨳', 'J' => '⨳J⨳', 'K' => '⨳K⨳', 'L' => '⨳L⨳', 'M' => '⨳M⨳', 'N' => '⨳N⨳','O' => '⨳O⨳', 'P' => '⨳P⨳', 'Q' => '⨳Q⨳', 'R' => '⨳R⨳', 'S' => '⨳S⨳', 'T' => '⨳T⨳', 'U' => '⨳U⨳', 'V' => '⨳V⨳', 'W' => '⨳W⨳', 'X' => '⨳X⨳', 'Y' => '⨳Y⨳', 'Z' => '⨳Z⨳');

    $fancyCharacters24 = array('A' => '[A̲̅]', 'B' => '[B̲̅]', 'C' => '[C̲̅]', 'D' => '[D̲̅]', 'E' => '[E̲̅]', 'F' => '[F̲̅]', 'G' => '[G̲̅]', 'H' => '[H̲̅]', 'I' => '[I̲̅]', 'J' => '[J̲̅]', 'K' => '[K̲̅]', 'L' => '[L̲̅]', 'M' => '[M̲̅]', 'N' => '[N̲̅]','O' => '[O̲̅]', 'P' => '[P̲̅]', 'Q' => '[Q̲̅]', 'R' => '[R̲̅]', 'S' => '[S̲̅]', 'T' => '[T̲̅]', 'U' => '[U̲̅]', 'V' => '[V̲̅]', 'W' => '[W̲̅]', 'X' => '[X̲̅]', 'Y' => '[Y̲̅]', 'Z' => '[Z̲̅]');

    $fancyCharacters25 = array('A' => '⊶A⊶', 'B' => '⊶B⊶', 'C' => '⊶C⊶', 'D' => '⊶D⊶', 'E' => '⊶E⊶', 'F' => '⊶F⊶', 'G' => '⊶G⊶', 'H' => '⊶H⊶', 'I' => '⊶I⊶', 'J' => '⊶J⊶', 'K' => '⊶K⊶', 'L' => '⊶L⊶', 'M' => '⊶M⊶', 'N' => '⊶N⊶','O' => '⊶O⊶', 'P' => '⊶P⊶', 'Q' => '⊶Q⊶', 'R' => '⊶R⊶', 'S' => '⊶S⊶', 'T' => '⊶T⊶', 'U' => '⊶U⊶', 'V' => '⊶V⊶', 'W' => '⊶W⊶', 'X' => '⊶X⊶', 'Y' => '⊶Y⊶', 'Z' => '⊶Z⊶');

    $fancyName1 = ''; 
    $fancyName2 = ''; 
    $fancyName3 = ''; 
    $fancyName4 = ''; 
    $fancyName5 = ''; 
    $fancyName6 = ''; 
    $fancyName7 = ''; 
    $fancyName8 = ''; 
    $fancyName9 = ''; 
    $fancyName10 = ''; 
    $fancyName11 = ''; 
    $fancyName12 = ''; 
    $fancyName13 = ''; 
    $fancyName14 = ''; 
    $fancyName15 = ''; 
    $fancyName16 = ''; 
    $fancyName17 = ''; 
    $fancyName18 = ''; 
    $fancyName19 = ''; 
    $fancyName20 = ''; 
    $fancyName21 = ''; 
    $fancyName22 = ''; 
    $fancyName23 = ''; 
    $fancyName24 = ''; 
    $fancyName25 = ''; 

    for ($i = 0; $i < strlen($name); $i++) {
     $char = strtoupper($name[$i]);
        if (isset($fancyCharacters1[$char])) {
        $fancyName1 .= $fancyCharacters1[$char];
        }
        if (isset($fancyCharacters2[$char])) {
        $fancyName2 .= $fancyCharacters2[$char];
        }
        if (isset($fancyCharacters3[$char])) {
        $fancyName3 .= $fancyCharacters3[$char];
        }
        if (isset($fancyCharacters4[$char])) {
        $fancyName4 .= $fancyCharacters4[$char];
        }
        if (isset($fancyCharacters5[$char])) {
        $fancyName5 .= $fancyCharacters5[$char];
        }
        if (isset($fancyCharacters6[$char])) {
        $fancyName6 .= $fancyCharacters6[$char];
        }
        if (isset($fancyCharacters7[$char])) {
        $fancyName7 .= $fancyCharacters7[$char];
        }
        if (isset($fancyCharacters8[$char])) {
        $fancyName8 .= $fancyCharacters8[$char];
        }
        if (isset($fancyCharacters9[$char])) {
        $fancyName9 .= $fancyCharacters9[$char];
        }
        if (isset($fancyCharacters10[$char])) {
        $fancyName10 .= $fancyCharacters10[$char];
        }
        if (isset($fancyCharacters11[$char])) {
        $fancyName11 .= $fancyCharacters11[$char];
        }
        if (isset($fancyCharacters12[$char])) {
        $fancyName12 .= $fancyCharacters12[$char];
        }
        if (isset($fancyCharacters13[$char])) {
        $fancyName13 .= $fancyCharacters13[$char];
        }
        if (isset($fancyCharacters14[$char])) {
        $fancyName14 .= $fancyCharacters14[$char];
        }
        if (isset($fancyCharacters15[$char])) {
        $fancyName15 .= $fancyCharacters15[$char];
        }
        if (isset($fancyCharacters16[$char])) {
        $fancyName16 .= $fancyCharacters16[$char];
        }
        if (isset($fancyCharacters17[$char])) {
        $fancyName17 .= $fancyCharacters17[$char];
        }
        if (isset($fancyCharacters18[$char])) {
        $fancyName18 .= $fancyCharacters18[$char];
        }
        if (isset($fancyCharacters19[$char])) {
        $fancyName19 .= $fancyCharacters19[$char];
        }
        if (isset($fancyCharacters20[$char])) {
        $fancyName20 .= $fancyCharacters20[$char];
        }
        if (isset($fancyCharacters21[$char])) {
        $fancyName21 .= $fancyCharacters21[$char];
        }
        if (isset($fancyCharacters22[$char])) {
        $fancyName22 .= $fancyCharacters22[$char];
        }
        if (isset($fancyCharacters23[$char])) {
        $fancyName23 .= $fancyCharacters23[$char];
        }
        if (isset($fancyCharacters24[$char])) {
        $fancyName24 .= $fancyCharacters24[$char];
        }
        if (isset($fancyCharacters25[$char])) {
        $fancyName25 .= $fancyCharacters25[$char];
        }
    
    elseif ($char === ' ') {
        $fancyName1 .= ' '; 
        $fancyName2 .= ' '; 
        $fancyName3 .= ' '; 
        $fancyName4 .= ' '; 
        $fancyName5 .= ' '; 
        $fancyName6 .= ' '; 
        $fancyName7 .= ' '; 
        $fancyName8 .= ' '; 
        $fancyName9 .= ' '; 
        $fancyName10 .= ' '; 
        $fancyName11 .= ' '; 
        $fancyName12 .= ' '; 
        $fancyName13 .= ' '; 
        $fancyName14 .= ' '; 
        $fancyName15 .= ' '; 
        $fancyName16 .= ' '; 
        $fancyName17 .= ' '; 
        $fancyName18 .= ' '; 
        $fancyName19 .= ' '; 
        $fancyName20 .= ' '; 
        $fancyName21 .= ' '; 
        $fancyName22 .= ' '; 
        $fancyName23 .= ' '; 
        $fancyName24 .= ' '; 
        $fancyName25 .= ' '; 
    }
    }

    $fancyName1= "-·=»‡«=·-".$fancyName1." -·=»‡«=·-";
    $fancyName2="•]••´º´•»".$fancyName2. " «•´º´••[•";
    $fancyName3="┕━━☽".$fancyName3. "☾━━┙";
    $fancyName4="╾━╤デ╦︻".$fancyName4."";
    $fancyName5="◥꧁ད".$fancyName5. " ཌ꧂◤";
    $fancyName6="╰☆☆".$fancyName6." ☆☆╮";
    $fancyName7="🌊 .·:*¨".$fancyName7."¨*:·. 🌊";
    $fancyName8="⫷".$fancyName8."⫸";
    $fancyName9="(¯´•._.•".$fancyName9. "•._.•´¯)";
    $fancyName10="•´¯`•.".$fancyName10.".•´¯`•";
    $fancyName11="꧁༒".$fancyName11."༒꧂";
    $fancyName12="𓂀".$fancyName12."𓂀";
    $fancyName13="▄︻デ".$fancyName13. "══━一";
    $fancyName14="°†° «[".$fancyName14. "]» °†°";
    $fancyName15="➶➶".$fancyName15. "➷➷";
    $fancyName16="(ㅅꈍ﹃ꈍ)*".$fancyName16."*(ꈍ﹃ꈍㅅ)♡";
    $fancyName17="ღ(¯`◕‿◕´¯)".$fancyName17."(¯`◕‿◕´¯)ღ";
    $fancyName18="╰┈➤ ❝".$fancyName18. "❞";
    $fancyName19="«-(¯`v´¯)-«".$fancyName19."»-(¯`v´¯)-»";
    $fancyName20="꧁𓊈𒆜".$fancyName20. "𒆜𓊉꧂";
    $fancyName21="×º°”˜`”°º×".$fancyName21. "×º°”˜`”°º×";
    $fancyName22="]|I{•-»".$fancyName22."«-•}I|[";
    $fancyName23="▁ ▂ ▄ ▅".$fancyName23." ▅ ▄ ▂ ▁";
    $fancyName25="*•.¸♡".$fancyName25."♡¸.•*";
    $fancyName24=" ̿̿ ̿̿ ̿̿ ̿'̿'̵͇̿̿з=".$fancyName24. "=ε/̵͇̿̿/'̿̿ ̿ ̿ ̿ ̿ ̿";

    return array($fancyName1, $fancyName2, $fancyName3, $fancyName4, $fancyName5, $fancyName6, $fancyName7, $fancyName8, $fancyName9, $fancyName10, $fancyName11, $fancyName12, $fancyName13, $fancyName14, $fancyName15, $fancyName16, $fancyName17, $fancyName18, $fancyName19, $fancyName20, $fancyName21, $fancyName22, $fancyName23, $fancyName24, $fancyName25); 

}
