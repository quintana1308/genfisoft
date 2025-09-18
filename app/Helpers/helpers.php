<?php

use App\Models\Contacts;
use App\Models\HistoryMessage;
use App\Models\Tag;
use App\Models\Message;

if (!function_exists('sideMenu')) {
    function sideMenu()
    {
        // Obtener el id del usuario logueado
        $userId = auth()->id();

        // Crear las instancias de los modelos
        $historyMessageModel = new HistoryMessage();
        $contactModel = new Contacts();
        $tagModel = new Tag();
        $messageModel = new Message();

        // Obtener los valores de cada función
        $messagesSentThisMonth = $historyMessageModel->getMessagesSentThisMonth($userId);
        $contactsCount = $contactModel->getContactsCount($userId);
        $tagsCount = $tagModel->getTagsCount($userId);
        $messagesCount = $messageModel->getMessagesCount($userId);

        $model_setCards = [
            'enviados' => $messagesSentThisMonth,
            'total_contactos' => $contactsCount,
            'total_tag' => $tagsCount,
            'total_messages' => $messagesCount
        ];

        $model_selectContactMessage = Contacts::selectContactMessage();

        return [
            'model_setCards' => $model_setCards,
            'model_selectContactMessage' => $model_selectContactMessage,
        ];
    }


    function formatPhoneNumber($phone)
    {    
        $phone = preg_replace('/[^\d\+]/', '', $phone);

        if (strpos($phone, '+') === 0) {
            return $phone;
        }

        if (strpos($phone, '5') === 0 || strpos($phone, '1') === 0) {
            return '+' . $phone;
        }
        
        // Aquí puedes acceder a la sesión de Laravel
        $prefix = session('prefix', '58'); // '58' por defecto si no existe
        return '+' . $prefix . $phone;
    }

    function formatPhoneLib($phone, $regionCode = null) {
        $phoneUtil = \libphonenumber\PhoneNumberUtil::getInstance();
        $response = [
            'formattedNumber' => '',
            'isValid' => false
        ];

        try {
            $phoneNumber = $phoneUtil->parse($phone, $regionCode);
            $response['formattedNumber'] = $phoneUtil->format($phoneNumber, \libphonenumber\PhoneNumberFormat::E164);
            $response['isValid'] = $phoneUtil->isValidNumber($phoneNumber);
        } catch (\libphonenumber\NumberParseException $e) {
            $response['formattedNumber'] = '';
            $response['isValid'] = false;
        }

        return $response;
    }

    function paisesYPref() {
        $paises = array(
            "Estados Unidos" => array("prefijo" => "+1", "flag" => "united-states.svg"),
            "Canadá" => array("prefijo" => "+1", "flag" => "canada.svg"),
            "México" => array("prefijo" => "+52", "flag" => "mexico.svg"),
            "Brasil" => array("prefijo" => "+55", "flag" => "brazil.svg"),
            "Argentina" => array("prefijo" => "+54", "flag" => "argentina.svg"),
            "Colombia" => array("prefijo" => "+57", "flag" => "colombia.svg"),
            "Chile" => array("prefijo" => "+56", "flag" => "chile.svg"),
            "Venezuela" => array("prefijo" => "+58", "flag" => "venezuela.svg"),
            "Perú" => array("prefijo" => "+51", "flag" => "peru.svg"),
            "Ecuador" => array("prefijo" => "+593", "flag" => "ecuador.svg"),
            "Cuba" => array("prefijo" => "+53", "flag" => "cuba.svg"),
            "Bolivia" => array("prefijo" => "+591", "flag" => "bolivia.svg"),
            "Costa Rica" => array("prefijo" => "+506", "flag" => "costa-rica.svg"),
            "Panamá" => array("prefijo" => "+507", "flag" => "panama.svg"),
            "Uruguay" => array("prefijo" => "+598", "flag" => "uruguay.svg"),
            "España" => array("prefijo" => "+34", "flag" => "spain.svg"),
            "Alemania" => array("prefijo" => "+49", "flag" => "germany.svg"),
            "Francia" => array("prefijo" => "+33", "flag" => "france.svg"),
            "Italia" => array("prefijo" => "+39", "flag" => "italy.svg"),
            "Reino Unido" => array("prefijo" => "+44", "flag" => "united-kingdom.svg"),
            "Rusia" => array("prefijo" => "+7", "flag" => "russia.svg"),
            "Ucrania" => array("prefijo" => "+380", "flag" => "ukraine.svg"),
            "Polonia" => array("prefijo" => "+48", "flag" => "poland.svg"),
            "Rumania" => array("prefijo" => "+40", "flag" => "romania.svg"),
            "Países Bajos" => array("prefijo" => "+31", "flag" => "netherlands.svg"),
            "Bélgica" => array("prefijo" => "+32", "flag" => "belgium.svg"),
            "Grecia" => array("prefijo" => "+30", "flag" => "greece.svg"),
            "Portugal" => array("prefijo" => "+351", "flag" => "portugal.svg"),
            "Suecia" => array("prefijo" => "+46", "flag" => "sweden.svg"),
            "Noruega" => array("prefijo" => "+47", "flag" => "norway.svg"),
            "China" => array("prefijo" => "+86", "flag" => "china.svg"),
            "India" => array("prefijo" => "+91", "flag" => "india.svg"),
            "Japón" => array("prefijo" => "+81", "flag" => "japan.svg"),
            "Corea del Sur" => array("prefijo" => "+82", "flag" => "south-korea.svg"),
            "Indonesia" => array("prefijo" => "+62", "flag" => "indonesia.svg"),
            "Turquía" => array("prefijo" => "+90", "flag" => "turkey.svg"),
            "Filipinas" => array("prefijo" => "+63", "flag" => "philippines.svg"),
            "Tailandia" => array("prefijo" => "+66", "flag" => "thailand.svg"),
            "Vietnam" => array("prefijo" => "+84", "flag" => "vietnam.svg"),
            "Israel" => array("prefijo" => "+972", "flag" => "israel.svg"),
            "Malasia" => array("prefijo" => "+60", "flag" => "malaysia.svg"),
            "Singapur" => array("prefijo" => "+65", "flag" => "singapore.svg"),
            "Pakistán" => array("prefijo" => "+92", "flag" => "pakistan.svg"),
            "Bangladés" => array("prefijo" => "+880", "flag" => "bangladesh.svg"),
            "Arabia Saudita" => array("prefijo" => "+966", "flag" => "saudi-arabia.svg"),
            "Egipto" => array("prefijo" => "+20", "flag" => "egypt.svg"),
            "Sudáfrica" => array("prefijo" => "+27", "flag" => "south-africa.svg"),
            "Nigeria" => array("prefijo" => "+234", "flag" => "nigeria.svg"),
            "Kenia" => array("prefijo" => "+254", "flag" => "kenya.svg"),
            "Marruecos" => array("prefijo" => "+212", "flag" => "morocco.svg"),
            "Argelia" => array("prefijo" => "+213", "flag" => "algeria.svg"),
            "Uganda" => array("prefijo" => "+256", "flag" => "uganda.svg"),
            "Ghana" => array("prefijo" => "+233", "flag" => "ghana.svg"),
            "Camerún" => array("prefijo" => "+237", "flag" => "cameroon.svg"),
            "Costa de Marfil" => array("prefijo" => "+225", "flag" => "ivory-coast.svg"),
            "Senegal" => array("prefijo" => "+221", "flag" => "senegal.svg"),
            "Tanzania" => array("prefijo" => "+255", "flag" => "tanzania.svg"),
            "Sudán" => array("prefijo" => "+249", "flag" => "sudan.svg"),
            "Libia" => array("prefijo" => "+218", "flag" => "libya.svg"),
            "Túnez" => array("prefijo" => "+216", "flag" => "tunisia.svg"),
            "Australia" => array("prefijo" => "+61", "flag" => "australia.svg"),
            "Nueva Zelanda" => array("prefijo" => "+64", "flag" => "new-zealand.svg"),
            "Fiji" => array("prefijo" => "+679", "flag" => "fiji.svg"),
            "Papúa Nueva Guinea" => array("prefijo" => "+675", "flag" => "papua-new-guinea.svg"),
            "Tonga" => array("prefijo" => "+676", "flag" => "tonga.svg"),
            "Irán" => array("prefijo" => "+98", "flag" => "iran.svg"),
            "Iraq" => array("prefijo" => "+964", "flag" => "iraq.svg"),
            "Jordania" => array("prefijo" => "+962", "flag" => "jordan.svg"),
            "Líbano" => array("prefijo" => "+961", "flag" => "lebanon.svg"),
            "Kuwait" => array("prefijo" => "+965", "flag" => "kuwait.svg"),
            "Emiratos Árabes Unidos" => array("prefijo" => "+971", "flag" => "united-arab-emirates.svg"),
            "Omán" => array("prefijo" => "+968", "flag" => "oman.svg"),
            "Catar" => array("prefijo" => "+974", "flag" => "qatar.svg"),
            "Bahrein" => array("prefijo" => "+973", "flag" => "bahrain.svg"),
            "Yemen" => array("prefijo" => "+967", "flag" => "yemen.svg"),
            "Afganistán" => array("prefijo" => "+93", "flag" => "afghanistan.svg"),
            "Albania" => array("prefijo" => "+355", "flag" => "albania.svg"),
            "Armenia" => array("prefijo" => "+374", "flag" => "armenia.svg"),
            "Azerbaiyán" => array("prefijo" => "+994", "flag" => "azerbaijan.svg"),
            "Bélgica" => array("prefijo" => "+32", "flag" => "belgium.svg"),
            "Bosnia y Herzegovina" => array("prefijo" => "+387", "flag" => "bosnia-and-herzegovina.svg"),
            "Bulgaria" => array("prefijo" => "+359", "flag" => "bulgaria.svg"),
            "Croacia" => array("prefijo" => "+385", "flag" => "croatia.svg"),
            "Chipre" => array("prefijo" => "+357", "flag" => "cyprus.svg"),
            "República Checa" => array("prefijo" => "+420", "flag" => "czech-republic.svg"),
            "Dinamarca" => array("prefijo" => "+45", "flag" => "denmark.svg"),
            "Estonia" => array("prefijo" => "+372", "flag" => "estonia.svg"),
            "Finlandia" => array("prefijo" => "+358", "flag" => "finland.svg"),
            "Hungría" => array("prefijo" => "+36", "flag" => "hungary.svg"),
            "Islandia" => array("prefijo" => "+354", "flag" => "iceland.svg"),
            "Irlanda" => array("prefijo" => "+353", "flag" => "ireland.svg"),
            "Letonia" => array("prefijo" => "+371", "flag" => "latvia.svg"),
            "Lituania" => array("prefijo" => "+370", "flag" => "lithuania.svg"),
            "Luxemburgo" => array("prefijo" => "+352", "flag" => "luxembourg.svg"),
            "Malta" => array("prefijo" => "+356", "flag" => "malta.svg"),
            "Mónaco" => array("prefijo" => "+377", "flag" => "monaco.svg"),
            "Montenegro" => array("prefijo" => "+382", "flag" => "montenegro.svg"),
            "Noruega" => array("prefijo" => "+47", "flag" => "norway.svg"),
            "Rumanía" => array("prefijo" => "+40", "flag" => "romania.svg"),
            "San Marino" => array("prefijo" => "+378", "flag" => "san-marino.svg"),
            "Serbia" => array("prefijo" => "+381", "flag" => "serbia.svg"),
            "Suiza" => array("prefijo" => "+41", "flag" => "switzerland.svg"),
            "Turquía" => array("prefijo" => "+90", "flag" => "turkey.svg"),
            "Ucrania" => array("prefijo" => "+380", "flag" => "ukraine.svg"),
            "Vaticano" => array("prefijo" => "+379", "flag" => "vatican-city.svg"),
            "Andorra" => array("prefijo" => "+376", "flag" => "andorra.svg"),
            "Austria" => array("prefijo" => "+43", "flag" => "austria.svg"),
            "Belice" => array("prefijo" => "+501", "flag" => "belize.svg"),
            "Botswana" => array("prefijo" => "+267", "flag" => "botswana.svg"),
            "Burkina Faso" => array("prefijo" => "+226", "flag" => "burkina-faso.svg"),
            "Burundi" => array("prefijo" => "+257", "flag" => "burundi.svg"),
            "Cabo Verde" => array("prefijo" => "+238", "flag" => "cape-verde.svg"),
            "Camerún" => array("prefijo" => "+237", "flag" => "cameroon.svg"),
            "Chad" => array("prefijo" => "+235", "flag" => "chad.svg"),
            "Comoras" => array("prefijo" => "+269", "flag" => "comoros.svg"),
            "Congo" => array("prefijo" => "+242", "flag" => "republic-of-the-congo.svg"),
            "República Democrática del Congo" => array("prefijo" => "+243", "flag" => "democratic-republic-of-congo.svg"),
            "Djibouti" => array("prefijo" => "+253", "flag" => "djibouti.svg"),
            "Egipto" => array("prefijo" => "+20", "flag" => "egypt.svg"),
            "Eritrea" => array("prefijo" => "+291", "flag" => "eritrea.svg"),
            "Etiopía" => array("prefijo" => "+251", "flag" => "ethiopia.svg"),
            "Gambia" => array("prefijo" => "+220", "flag" => "gambia.svg"),
            "Gana" => array("prefijo" => "+233", "flag" => "ghana.svg"),
            "Guinea" => array("prefijo" => "+224", "flag" => "guinea.svg"),
            "Guinea-Bisáu" => array("prefijo" => "+245", "flag" => "guinea-bissau.svg"),
            "Ivory Coast" => array("prefijo" => "+225", "flag" => "ivory-coast.svg"),
            "Liberia" => array("prefijo" => "+231", "flag" => "liberia.svg"),
            "Malawi" => array("prefijo" => "+265", "flag" => "malawi.svg"),
            "Mali" => array("prefijo" => "+223", "flag" => "mali.svg"),
            "Mauritania" => array("prefijo" => "+222", "flag" => "mauritania.svg"),
            "Mauricio" => array("prefijo" => "+230", "flag" => "mauritius.svg"),
            "Mozambique" => array("prefijo" => "+258", "flag" => "mozambique.svg"),
            "Namibia" => array("prefijo" => "+264", "flag" => "namibia.svg"),
            "Níger" => array("prefijo" => "+227", "flag" => "niger.svg"),
            "Nigeria" => array("prefijo" => "+234", "flag" => "nigeria.svg"),
            "Ruanda" => array("prefijo" => "+250", "flag" => "rwanda.svg"),
            "Santo Tomé y Príncipe" => array("prefijo" => "+239", "flag" => "sao-tome-and-prince.svg"),
            "Senegal" => array("prefijo" => "+221", "flag" => "senegal.svg"),
            "Sierra Leona" => array("prefijo" => "+232", "flag" => "sierra-leone.svg"),
            "Somalia" => array("prefijo" => "+252", "flag" => "somalia.svg"),
            "Sudán del Sur" => array("prefijo" => "+211", "flag" => "south-sudan.svg"),
            "Suazilandia" => array("prefijo" => "+268", "flag" => "swaziland.svg"),
            "Siria" => array("prefijo" => "+963", "flag" => "syria.svg"),
            "Tayikistán" => array("prefijo" => "+992", "flag" => "tajikistan.svg"),
            "Togo" => array("prefijo" => "+228", "flag" => "togo.svg"),
            "Yibuti" => array("prefijo" => "+253", "flag" => "djibouti.svg"),
            "Zambia" => array("prefijo" => "+260", "flag" => "zambia.svg"),
            "Zimbabue" => array("prefijo" => "+263", "flag" => "zimbabwe.svg")
        );

        // Ordenar alfabéticamente por nombre de país
        ksort($paises);

        return $paises;
    }

    function strClean($strCadena)
    {
        $string = preg_replace(['/\s+/', '/^\s|\s$/'], [' ', ''], $strCadena);
        $string = trim($string);
        $string = stripslashes($string);
        $string = str_ireplace("<script>", "", $string);
        $string = str_ireplace("</script>", "", $string);
        $string = str_ireplace("<script src>", "", $string);
        $string = str_ireplace("<script> type=>", "", $string);
        $string = str_ireplace("SELECT * FROM", "", $string);
        $string = str_ireplace("DELETE FROM", "", $string);
        $string = str_ireplace("INSERT INTO", "", $string);
        $string = str_ireplace("SELECT COUNT(*) FROM", "", $string);
        $string = str_ireplace("DROP TABLE", "", $string);
        $string = str_ireplace("OR '1'='1", "", $string);
        $string = str_ireplace('OR "1"="1"', "", $string);
        $string = str_ireplace('OR ´1´=´1´', "", $string);
        $string = str_ireplace("is NULL; --", "", $string);
        $string = str_ireplace('is NULL; --', "", $string);
        $string = str_ireplace("LIKE '", "", $string);
        $string = str_ireplace('LIKE "', "", $string);
        $string = str_ireplace("LIKE ´", "", $string);
        $string = str_ireplace("OR 'a'='a", "", $string);
        $string = str_ireplace('OR "a"="a', "", $string);
        $string = str_ireplace("OR ´a´=´a", "", $string);
        $string = str_ireplace('OR ´a´=´a', "", $string);
        $string = str_ireplace("--", "", $string);
        $string = str_ireplace("^", "", $string);
        $string = str_ireplace("[", "", $string);
        $string = str_ireplace("]", "", $string);
        $string = str_ireplace("==", "", $string);
        return $string;
    }

    function br2nl($string)
    {
        return preg_replace('/\<br(\s*)?\/?\>/i', "", $string);
    }

}
