<script>
    export let board, questions, boardRequest;
    console.log(board)
    console.log(questions)
    console.log(boardRequest)
</script>

<div class="h-screen bg-[#E0F7FA]">
    <header class="bg-[#40A0C1] text-white w-full h-12 flex justify-end items-center">
        <div class="w-10 h-10 bg-black rounded-full mr-4"></div>
    </header>

    <div class="text-center pt-10">
        <h1 class="text-4xl mb-5">Breng Vragen vanuit de chat naar dit bord</h1>
        <h2 class="text-2xl mb-10">Code: {boardRequest.rngcode}</h2>
    </div>

    <div class="flex flex-wrap justify-center">
        {#each questions as question}
            <div class="w-40 h-10 bg-[#C4F0FF] rounded-md flex justify-center items-center m-2">
                {question.text}
            </div>
        {/each}
    </div>
</div>
