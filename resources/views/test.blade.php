<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title id="title">weekly-quiz</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/logo.png') }}" class="rounded-md">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>

        #question {
            word-wrap: break-word;
            word-break: break-word;
            white-space: normal;
            overflow-wrap: break-word;
            text-align: center;
        }

        #question-box {
            overflow: hidden;
            text-align: center;
        }


        #question_image {
            max-width: 100%;
            height: auto;
            display: block;
            margin: 0 auto;
        }


        .options {
            white-space: normal;
            word-wrap: break-word;
            word-break: break-word;
        }

        .selected {
            pointer-events: none;
            cursor: not-allowed;
        }

        @media (max-width: 640px) {
            #logo {
                top: 1%;
                right: 1%;
                left: auto;
            }
            #back{
                top: 1%;
                left: 1%;
                left: auto;
            }
        }
    </style>
</head>
<body class="font-sans">

<div class="main bg-gradient-to-r from-purple-700 to-blue-200 select-none w-full h-screen flex justify-between gap-1 gap-2 items-center flex-col overflow-auto">
    <!-- Logo Section -->
<div class="w-full flex justify-between items-center lg:top-0 lg:absolute">
    <div id="logo" class="logo ml-2 mt-2 sm:left-10 w-[50px] sm:w-[50px] md:left-10 lg:left-10 xl:left-10 md:w-[100px] rounded-lg shadow-lg">
        <img src="{{ asset('assets/logo.png') }}" alt="Logo" class="w-full rounded-lg shadow-md">
    </div>
    <a href="{{ route('weekly.quiz') }}" class="mr-2"><img src="{{ asset('assets/back.png') }}" alt="Logo" class="h-12 w-auto"></a>
</div>


    <!-- Heading Section -->
<div class="w-[95%] h-full py-5 flex justify-start items-center flex-col gap-2">
    <h1 id="quiz-heading" class="px-8 bg-white sm:text-md md:text-3xl lg:text-md text-md font-bold text-center text-purple-800  border-2 p-2 rounded-lg shadow-sm"></h1>
    <!-- Quiz Question Box -->
                <div id="question-box" class="flex flex-col justify-center items-center bg-white w-full lg:max-w-[700px] py-5 rounded-xl shadow-xl gap-1 overflow-hidden">
                    <div id="question" class="text-base lg:text-xl text-gray-800 font-semibold w-full px-2 py-1 text-left"></div>
                    <img id="question_image" src="" class="w-[90%] lg:w-auto h-auto">
                </div>

                <!-- Answer Buttons Section -->
                <div id="options-box" class="grid grid-cols-1 max-w-[700px] sm:grid-cols-2 gap-2 w-full">
                    <button id="opt_1" class="options bg-gray-100 py-4 px-8 rounded-lg shadow-lg text-md text-black md:text-lg break-words">No Data Error _1</button>
                    <button id="opt_2" class="options bg-gray-100 py-4 px-8 rounded-lg shadow-lg text-md text-black md:text-lg break-words">No Data Error _2</button>
                    <button id="opt_3" class="options bg-gray-100 py-4 px-8 rounded-lg shadow-lg text-md text-black md:text-lg break-words">No Data Error _3</button>
                    <button id="opt_4" class="options bg-gray-100 py-4 px-8 rounded-lg shadow-lg text-md text-black md:text-lg break-words">No Data Error _4</button>
                </div>


             <!-- Next Button -->
            <button id="next-button" class="w-[200px] sm:w-[250px] py-3 bg-purple-800 text-white rounded-lg text-lg hover:bg-white hover:text-black transition mt-5 font-bold" disabled>
                Next
            </button>


</div>
<footer class="text-white text-center w-full sticky bottom-0">
    <p class="text-sm">&copy; Rohan Book Company Pvt. Ltd. All Rights Reserved</p>
</footer>

</div>




<!-- Result Box -->
<div id="result-box" class="hidden bg-gradient-to-r from-purple-700 to-blue-200 w-full h-screen flex justify-center items-center gap-5 px-4 overflow-hidden">
    <div class="bg-white rounded w-[400px] h-[300px] text-5xl font-bold text-white flex justify-center items-center flex-col gap-5">
        <div id="logo" class="logo w-[150px] sm:w-[200px]">
            <img src="{{ asset('./assets/logo.png') }}" alt="Logo" class="w-full h-auto">
        </div>
        <p class="text-4xl text-blue-900">You Score = <span id="correct-answers"></span></p>
        <button class="w-[100px] h-[50px] bg-orange-600 text-xl rounded text-white" onclick="window.location.reload();">Retry</button>
    </div>
</div>



<script>
const options = document.querySelectorAll('.options');

// Loop through each option
options.forEach((option) => {
    option.addEventListener('click', (e) => {
        // Remove green background from all options
        options.forEach((opt) => opt.classList.remove('bg-green-600', 'bg-orange-500', 'selected'));  // Reset the backgrounds

        e.target.classList.add('bg-green-600');
        e.target.classList.add('selected');
    });
});

// Assuming questions are in this format
const questions = @json($allQuestions);
const questions_length = questions.length;
let currentQuestionIndex = 0;
let questionindex = 1;
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
    // document.getElementById('title').innerText = questionData.ques_id;
    document.getElementById('quiz-heading').innerHTML = `💡 ${questionData.quiztopics.topic_name} 💡`;
    // document.getElementById('questionIndex').innerText = 'Q' + questionindex;
    // document.getElementById('question').innerHTML = "Q" + questionindex + '. ' + questions[currentQuestionIndex].question;
 document.getElementById('question').innerHTML = `<strong>Q${questionindex}</strong>. ${ questions[currentQuestionIndex].question}`;



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
    optionButtons.forEach(button => button.classList.remove('bg-green-600', 'bg-orange-500', 'selected'));

    // Enable Next button
    document.getElementById('next-button').disabled = false;
}

// Function to handle Next button click
function showNextQuestion() {
    const selectedOption = document.querySelector('.options.bg-green-600');
    if (!selectedOption) {
        alert("Please select an answer before proceeding.");
        return;
    }

    // Convert selected option and correct answer to uppercase for comparison
    const selectedAnswer = selectedOption.innerText.trim().toUpperCase();
    const correctAnswer = questions[currentQuestionIndex].answer.trim().toUpperCase();

    // console.log("selected Answer = ", selectedAnswer);
    // console.log("Correct Answer = ", correctAnswer);

    // Compare both answers
    if (selectedAnswer === correctAnswer) {
        score++;
    }

    // Move to next question or show result
    if (currentQuestionIndex < questions.length - 1) {
        currentQuestionIndex++;
        questionindex++;
        displayQuestion();
    } else {
        displayResult();
    }

    // Reset the background color for all options when moving to next question
    const optionButtons = document.querySelectorAll('.options');
    optionButtons.forEach(button => button.classList.remove('bg-green-600', 'bg-orange-500'));
    // Re-enable hover functionality for all options
    optionButtons.forEach(button => button.classList.remove('selected'));
}


// Function to display the result
function displayResult() {
    document.getElementById('result-box').classList.remove('hidden');
    document.getElementById('correct-answers').innerText = score+ '/'+ questions_length;
    document.querySelector('.main').classList.add('hidden');
    document.getElementById('next-button').classList.add('hidden');
}
</script>




</body>
</html>
