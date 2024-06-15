<script>
    import {inertia, Link, useForm} from '@inertiajs/svelte'
    import NewBoardModal from "@/Components/NewBoardModal.svelte";
    export let boards;

    let JBP = useForm({
        code: ""
    })
    let NewModalPost = useForm({
        title: "",
    });
    let NBModal = false;
    function closeModal()
    {
        NBModal = false
    }
</script>

{#if NBModal}
    <NewBoardModal NMP={NewModalPost} modal={closeModal} joinBoard={JBP}></NewBoardModal>
{/if}

<div class="bg-white dark:bg-gray-900 flex flex-col">
    <h1 class="font-sans text-black dark:text-white text-center text-2xl">Boards</h1>
    <div class="flex">
        {#each boards as board}
            <a href={"/digibord/"+board.id} use:inertia>
                <div class="bg-gray-700 hover:bg-blue-400 min-h-12 text-center w-56 ml-4 mr-4">
                    <h2 class="text-white text-xl">{board.Title}</h2>
                </div>
            </a>
        {/each}

        <div class="bg-gray-600 min-h-12 text-center w-56 ml-4 mr-4 hover:cursor-pointer hover:bg-gray-700 hover:text-white"
        on:click={()=>{NBModal = true}}>
            <h2 class="text-xl"> + </h2>
        </div>

    </div>

</div>
