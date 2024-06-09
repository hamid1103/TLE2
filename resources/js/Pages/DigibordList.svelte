<script>
    export let boards;
</script>

<div class="bg-white dark:bg-gray-900 ">
    {#each boards as board}
        <div class="bg-gray-700 min-h-64 w-56">
            <h2>{board.title}</h2>
        </div>
    {/each}
</div>
