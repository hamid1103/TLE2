<script>
    export let NMP, modal, joinBoard;
    let NameEmpty;
</script>

<div class="fixed h-screen w-screen bg-gray-700 bg-opacity-75 flex flex-col justify-center align-middle items-center z-50">

    <div class="w-3/5 flex justify-end bg-white">
        <button class="bg-red-500 w-16" on:click={()=>{modal()}}>
            X
        </button>
    </div>

    <div class="w-3/5 h-2/6 bg-white opacity-100 flex justify-evenly items-center">
        <div class="flex w-2/6 flex-col align-middle items-center mb-10">
            <h2>Maak een bord</h2>
            <div class="flex align-middle mb-2">
                <label for="BoardTitle" class="mr-2 flex flex-col items-center">
                    <span class="font-sans text-black text-xl p-2">Titel:</span>
                    {#if NameEmpty}
                        <span class="font-sans text-red text-lg">Titel mag niet leeg zijn</span>
                    {/if}
                </label>
                <input id="BoardTitle" class="border-2 rounded-md p-2" bind:value={$NMP.title}>
            </div>

            <button class="bg-blue-300 rounded font-bold text-xl p-3 mt-3" on:click={()=>{
                console.log($NMP.title)
                if($NMP.title === "" || undefined)
                    {
                        NameEmpty = true
                        return
                    }else{
                    $NMP.post('/digibord')
                    }
               }}>Maak nieuw bord</button>
        </div>

        <div class="h-5/6 border"></div>

        <div class="flex w-2/6 flex-col align-middle items-center mb-10">
            <h2>Voeg een bestaand bord toe</h2>
            <div class="flex mb-2">
                <label for="BoardTitle" class="mr-2 p-2">
                    <span class="font-sans text-black text-xl">Titel:</span>
                </label>
                <input id="BoardTitle" class="border-2 rounded-md p-2" bind:value={$joinBoard.code}>
            </div>
            <button class="bg-blue-300 rounded font-bold text-xl p-3 mt-3" on:click={()=>{$joinBoard.post('/joinCode')}}>Voeg toe</button>
        </div>
    </div>
</div>
