<script>
    export let board, questions, boardRequest;
    console.log(board)
    console.log(questions)
    console.log(boardRequest)
</script>

<div class="h-screen bg-[#F4FFFE]">
    <header class="bg-[#40A0C1] text-white w-full h-12 flex justify-end items-center">
        <div class="w-10 h-10 bg-black rounded-full mr-4"></div>
    </header>

    <div class="text-center pt-10">
        <h1 class="text-4xl mb-5">Breng jullie vragen vanuit de chat naar dit bord</h1>
        <h2 class="text-2xl mb-10">Code: {boardRequest.rngcode}</h2>
    </div>

    <div class="flex flex-wrap justify-center">
        <div class="w-5/12 bg-[#C4F0FF] rounded-md flex justify-center items-center m-2 p-2">
            Hoe lang duurt het voordat de zon de aarde bereikt?
        </div>
        <div class="w-5/12 bg-[#C4F0FF] rounded-md flex justify-center items-center m-2 p-2">
            Wat was de naam van die ene persoon die heerste over de romeinse rijk?
<!--            en verantwoordelijk was voor de verdeling tussen het oosten en westen?-->
        </div>
        <div class="w-5/12 bg-[#C4F0FF] rounded-md flex justify-center items-center m-2 p-2">
            Wat is de naam van schrijver van Dolfje Weerwolfje?
        </div>










        {#each questions as question}
            <div class="w-40 h-10 bg-[#C4F0FF] rounded-md flex justify-center items-center m-2">
                {question.Content}
            </div>
        {/each}
    </div>
</div>
