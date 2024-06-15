<script>
    export let modalClose, ChatID;
</script>

<div class="fixed h-screen w-screen bg-gray-700 bg-opacity-75 flex flex-col justify-center align-middle items-center z-50">
    <div class="w-3/5 flex justify-end bg-blue-600"><button class="bg-red-500 w-24" on:click={()=>{modalClose(); console.log("Modal should be closed rn")}}>X</button></div>
    <div class="w-3/5 h-2/6 bg-blue-600 opacity-100 flex justify-between">
        <div class="flex w-2/6 flex-col align-middle items-center">
            <h2>Maak een bord</h2>
            <div class="flex align-middle mb-2">
                <label for="BoardTitle" class="mr-2 "><span class="font-sans text-black text-xl">Titel</span></label>
                <input id="BoardTitle" class="rounded-md p-2" bind:value={$NMP.title}>
            </div>

            <button class="bg-green-400 rounded font-bold text-xl p-3" on:click={()=>{$NMP.post('/digibord')}}>Maak nieuw bord</button>
        </div>

        <div class="h-5/6 border"></div>

        <div class="flex w-2/6 flex-col align-middle items-center">
            <h2>Voeg een bestaand bord toe.</h2>
            <div class="flex align-middle mb-2">
                <label for="BoardTitle" class="mr-2 "><span class="font-sans text-black text-xl">Titel</span></label>
                <input id="BoardTitle" class="rounded-md p-2" bind:value={$joinBoard.code}>
            </div>
            <button class="bg-green-400 rounded font-bold text-xl p-3" on:click={()=>{$joinBoard.post('/joinCode')}}>Voeg toe</button>
        </div>
    </div>
</div>
