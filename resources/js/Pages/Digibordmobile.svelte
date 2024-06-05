<style>
    :global(body) {
        @apply bg-[#C4F0FF] h-screen m-0;
    }
    textarea {
        resize: none;
    }
</style>

<div class="overflow-hidden h-screen flex flex-col">
    <!-- Header -->
    <header class="header bg-[#40A0C1] text-white w-full h-12 flex justify-end items-center">
        <div class="black-circle relative before:content-[''] before:inline-block before:w-10 before:h-10 before:bg-black before:rounded-full before:mr-2.5"></div>
    </header>
    <h2 class="text-lg font-bold mb-4">Room: ABCD</h2>
    <!-- Main Content -->
    <div class="flex-grow flex flex-col items-center justify-center p-4">
        <p class="text-xl font-bold mb-6">Typ hieronder je vraag</p>
        <p class="text-gray-600 mb-4">Geen zorgen, er zijn geen foute vragen!</p>
        <div class="bg-white w-full max-w-md rounded-lg p-6 shadow-md">
            <div class="text-center"></div>
            <form class="flex flex-col items-center">
                <textarea class="w-full h-48 p-2  border-gray-300 rounded mb-4" placeholder="Vraag maar raak!"></textarea>
                <button type="submit" class="bg-[#40A0C1] text-white px-4 py-2 rounded">Sturen</button>
            </form>
        </div>
    </div>
</div>
