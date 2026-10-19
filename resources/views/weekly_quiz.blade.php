<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MCQ Quiz</title>
    <link rel="icon" href="{{ asset('logo.png') }}" type="image/png">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>

    @media (max-width: 640px) {
        #logo {
            top: 0;
            right: 0;
            left: auto; /* Avoid left positioning on smaller devices */
        }
    }
        </style>
</head>
<body>

    {{-- <div class="main bg-[url({{ asset('./assets/bg4.png') }})] bg-cover select-none w-full h-screen flex justify-center items-center flex-col gap-3 px-4 overflow-hidden relative"> --}}

        <div class="main bg-gradient-to-r from-purple-700 to-blue-200 select-none w-full h-screen flex justify-center items-center flex-col gap-3 px-4 overflow-hidden relative">
        <!-- Logo Section (Mobile pe right-top corner me shift) -->
        <div id="logo" class="logo absolute top-[4rem] left-4 sm:left-10 w-[70px] sm:w-[70px] md:left-10 lg:left-10 xl:left-10 md:w-[100px] rounded-lg shadow-lg">
            <img src="{{ asset('assets/logo.png') }}" alt="Logo" class="w-full h-auto rounded-lg shadow-md">
        </div>


        <!-- Heading Section -->
        <h1 id="quiz-heading" class="absolute top-0 bg-white sm:text-md md:text-md lg:text-md text-md font-bold text-center text-black border-2 p-3 px-5 rounded-lg shadow-sm">
            Topic :
        </h1>

        <!-- Quiz Question Box -->
        <div id="question-box" class="bg-white max-w-[700px] sm:min-h-[300px] md:min-h-[300px] lg:min-h-[300px] w-full h-[200px] p-8 rounded-xl shadow-xl flex flex-col justify-center items-center gap-1 overflow-hidden">
            <h2 id="question" class="text-md text-gray-800 font-semibold text-center">
                <!-- Question will go here -->
            </h2>
            <img id="question_image" src="" class="w-1/2">
        </div>

        <!-- Answer Buttons Section -->
        <div id="options-box" class="grid grid-cols-1 max-w-[600px] sm:grid-cols-2 gap-4 w-full overflow-hidden">
            <button id="opt_1" class="options w-full bg-white py-4 px-8 rounded-lg shadow-lg text-sm text-black hover:bg-orange-500">No Data Error _1</button>
            <button id="opt_2" class="options w-full bg-white py-4 px-8 rounded-lg shadow-lg text-sm text-black hover:bg-orange-500">No Data Error _2</button>
            <button id="opt_3" class="options w-full bg-white py-4 px-8 rounded-lg shadow-lg text-sm text-black hover:bg-orange-500">No Data Error _3</button>
            <button id="opt_4" class="options w-full bg-white py-4 px-8 rounded-lg shadow-lg text-sm text-black hover:bg-orange-500">No Data Error _4</button>
        </div>

        <!-- Next Button -->
        <button id="next-button" class="w-[200px] sm:w-[250px] py-4 bg-orange-500 text-white rounded-lg text-lg hover:bg-white hover:text-black transition mt-5" disabled>
            Next
        </button>

        <!-- Result Section -->
    </div>

    <!-- Result Box -->
    <div id="result-box" class="hidden bg-[url({{ asset('./assets/bg4.png') }})] bg-cover w-full h-screen flex justify-center items-center gap-5 px-4 overflow-hidden">
        <div class="bg-white rounded w-[400px] h-[300px] text-5xl font-bold text-white flex justify-center items-center flex-col gap-5">
            <div id="logo" class="logo w-[150px] sm:w-[200px]">
                <img src="{{ asset('./assets/logo.png') }}" alt="Logo" class="w-full h-auto">
            </div>
            <p class="text-4xl text-blue-900">You Score = <span id="correct-answers"></span> /5</p>
            <button class="w-[100px] h-[50px] bg-orange-600 text-xl rounded text-white" onclick="window.location.reload();">Retry</button>
        </div>
    </div>



<script>
const options = document.querySelectorAll('.options');

// Loop through each option
options.forEach((option) => {
    option.classList.add('bg-white'); // Default background color

    option.addEventListener('click', (e) => {
        // Remove green background from all options
        options.forEach((opt) => opt.classList.remove('bg-green-600', 'bg-orange-500'));  // Reset the backgrounds

        // Add green background to clicked option
        e.target.classList.add('bg-orange-500');
    });
});

// Assuming questions are in this format
const questions = @json($allQuestions);
console.log(questions);
let currentQuestionIndex = 0;
let score = 0;

document.addEventListener('DOMContentLoaded', function () {
    displayQuestion();
    document.getElementById('next-button').addEventListener('click', showNextQuestion);
});

// Function to display the question and options
function displayQuestion() {
    const questionData = questions[currentQuestionIndex];
    const question_image = document.getElementById('question_image');

    // Update question text
    document.getElementById('quiz-heading').innerText = "Topic : " + questionData.quiztopics.topic_name;

    document.getElementById('question').innerText = questionData.question;

    // Show image if it exists
    if(questionData.filePath) {
        question_image.src = `/storage/${questionData.filePath}`;
        question_image.style.display = 'block'; // Make the image visible
    } else {
        question_image.style.display = 'none'; // Hide the image if no file path exists
    }

    // Update options
    document.getElementById('opt_1').innerText = questionData.option_1;
    document.getElementById('opt_2').innerText = questionData.option_2;
    document.getElementById('opt_3').innerText = questionData.option_3;
    document.getElementById('opt_4').innerText = questionData.option_4;

    // Reset button styles (clear previous selection)
    const optionButtons = document.querySelectorAll('.options');
    optionButtons.forEach(button => button.classList.remove('bg-orange-500'));

    // Enable Next button
    document.getElementById('next-button').disabled = false;
}

// Function to handle Next button click
function showNextQuestion() {
    const selectedOption = document.querySelector('.options.bg-orange-500');
    if (!selectedOption) {
        alert("Please select an answer before proceeding.");
        return;
    }

    // Check if the selected option is correct
    const selectedAnswer = selectedOption.innerText;
    if (selectedAnswer === questions[currentQuestionIndex].answer) {
        score++;
    }

    // Move to next question or show result
    if (currentQuestionIndex < questions.length - 1) {
        currentQuestionIndex++;
        displayQuestion();
    } else {
        displayResult();
    }
}

// Function to display the result
function displayResult() {
    document.getElementById('result-box').classList.remove('hidden');
    document.getElementById('correct-answers').innerText = score;
    document.querySelector('.main').classList.add('hidden');
    document.getElementById('next-button').classList.add('hidden');
}

// Function to handle option selection and change background color
document.querySelectorAll('.options').forEach(button => {
    button.addEventListener('click', function () {
        // Reset all options' background colors
        const optionButtons = document.querySelectorAll('.options');
        optionButtons.forEach(btn => btn.classList.remove('bg-orange-500'));

        // Mark the clicked option as selected and change its background color
        button.classList.add('bg-orange-500');
    });
});
</script>


</body>
</html>
