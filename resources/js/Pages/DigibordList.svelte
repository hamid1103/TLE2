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

<div class="h-screen bg-[#F4FFFE] dark:bg-gray-900 flex flex-col overflow-y-auto overflow-x-hidden">

    <header class="bg-[#40A0C1] text-white w-full h-12 flex justify-end items-center">
        <div class="w-10 h-10 bg-black rounded-full mr-4"></div>
    </header>

    <div class="text-center pt-2">
        <h1 class="text-4xl mb-5 text-white">Board</h1>
    </div>
    <div class="w-screen flex flex-wrap">
        {#each boards as board}
            <a href={"/digibord/"+board.id} use:inertia>
                <div class="bg-[#C4F0FF] text-center flex justify-center items-center w-56 ml-4 mr-4 mb-4 p-3 hover:text-white">
                    <h2 class="text-xl">{board.Title}</h2>
                </div>
            </a>
        {/each}

        <div class="bg-[#C4F0FF] text-center flex justify-center items-center w-56 ml-4 mr-4 mb-4 p-3 hover:cursor-pointer hover:bg-[#0000AB] hover:text-white"
        on:click={()=>{NBModal = true}}>
            <h2 class="text-xl"> + </h2>
        </div>

    </div>

</div>
