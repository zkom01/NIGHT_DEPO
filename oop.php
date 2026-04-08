<body>
    <?php $pageTitle = "OOP"; require 'assets/header.php'; ?>

    <main>
        <section class='oop'>

<?php

require './classes/Database.php';

$dbClass = new Database();
echo "Pokouším se o připojení...<br>";

// Tato metoda by měla selhat, zapsat do logu a ukončit skript přes die()
$conn = $dbClass->connectionDB();

echo "Pokud vidíte toto, připojení se povedlo.<br><br>";

    class Book {
        // Statická vlastnost, která si pamatuje počet všech vytvořených knih
        public static $totalBooks = 0;
        public $title;
        public $author;
        public $year;
        public $price;

        function __construct($title, $author, $year, $price){
            $this->title = $title;
            $this->author = $author;
            $this->year = $year;
            $this->price = $price;
            self::$totalBooks++;
        }

        function bookDescription(){
            return "Název knihy: " . $this->title . "<br>" .
                   "Autor: " . $this->author . "<br>" .
                   "Rok vydání: " . $this->year . "<br>" .
                   "Cena: " . $this->price . " Kč" . "<br><br>";
        }

        public static function allBook($count){
            for ($i = 1; $i <= $count; $i++) {
                $atribut = "book_".$i;
                global ${$atribut};
                echo ${$atribut}->bookDescription();
            }
        }

        function changePriceAmount($amount){
            $this->price = $this->price + $amount;
        }

        function changePriceAmountPercent($amountPercent){
            $this->price = $this->price + ($this->price * $amountPercent/100);
        }

    }


    $book_1 = new Book("Php v akci", "Eda", 1981, 899);
    $book_2 = new Book("Mistrovství v JavaScriptu", "Jan Novák", 2015, 549);
    $book_3 = new Book("Algoritmy a datové struktury", "Alena Modrá", 2020, 420);
    $book_4 = new Book("Python pro začátečníky", "Petr Swift", 2022, 350);
    $book_5 = new Book("Návrhové vzory v praxi", "Karel Objektový", 2018, 720);
    $book_6 = new Book("Moderní SQL", "Marie Databázová", 2019, 480);
    $book_7 = new Book("Čistý kód", "Robert Martin", 2008, 650);
    $book_8 = new Book("Docker a Kubernetes", "Lukáš Cloud", 2021, 599);
    $book_9 = new Book("Úvod do strojového učení", "Eva Robotová", 2023, 890);
    $book_10 = new Book("Bezpečnost webových aplikací", "Filip Hacker", 2017, 415);
    $book_11 = new Book("sračka", "Filip Hacker", 2017, 415);
    $book_12 = new Book("sračkascsca", "Filip Hacker", 2017, 415);

    // for ($i = 1; $i <= 10; $i++) {
    //     $atribut = "book_".$i;
    //     echo ${$atribut}->bookDescription();
    // }

    echo $book_1->bookDescription();
    $book_1->changePriceAmountPercent(-10);
    // echo $book_1->bookDescription();
    Book::allBook(Book::$totalBooks);
    echo Book::$totalBooks


















?>
        </section>
    </main>

    <?php require 'assets/footer.php'; ?>

</body>
</html>

