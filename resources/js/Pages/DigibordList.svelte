<script>
    import { inertia, Link } from '@inertiajs/svelte'
    export let boards;

</script>

<div class="bg-white dark:bg-gray-900 flex flex-col">
    <h1 class="font-sans text-black dark:text-white text-center text-2xl">Boards</h1>
    <div class="flex">
        {#each boards as board}
            <a href={"/digibord/"+board.id} use:inertia>

            </a>
            <div class="bg-gray-700 min-h-12 text-center w-56 ml-4 mr-4">
                <h2>{board.title}</h2>
            </div>
        {/each}

        <div class="bg-gray-600 min-h-12 text-center w-56 ml-4 mr-4">
            <h2 class="text-xl"> + </h2>
        </div>

    </div>

</div>
