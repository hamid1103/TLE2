<script>
    import {inertia, Link, useForm} from '@inertiajs/svelte'
    import NewBoardModal from "@/Components/NewBoardModal.svelte";
    import axios from "axios";
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

    const logout = async () => {
        try {
            // Verstuur een POST-verzoek naar de logout route
            await axios.post('/logout');
            // Na succesvolle logout, redirect naar de login pagina
            window.location.href = '/login';
        } catch (error) {
            console.error('Error during logout:', error);
        }
    }
</script>

<style>
.custom-circle::before {
    content: '';
    display: inline-block;
    width: 2.5rem; /* 10 * 0.25rem */
    height: 2.5rem;
    background-image: url('../../img/login.png');
    background-size: cover;
    background-position: center;
    border-radius: 50%;
    margin-right: 0.625rem; /* 2.5 * 0.25rem */
    background-color: white; /* Fallback in case the image doesn't load */
}
</style>

{#if NBModal}
    <NewBoardModal NMP={NewModalPost} modal={closeModal} joinBoard={JBP}></NewBoardModal>
{/if}

<div class="h-screen bg-[#F4FFFE] dark:bg-gray-900 flex flex-col overflow-y-auto overflow-x-hidden">

    <header class="bg-[#40A0C1] text-white w-full h-12 flex justify-end items-center">
        <button
            class="black-circle relative custom-circle"
            on:click={logout}
            title="Klik om uit te loggen"
            aria-label="Uitloggen">
        </button>
    </header>

    <div class="text-center pt-2">
        <h1 class="text-4xl mb-5 text-white">Board</h1>
    </div>
    <div class="w-screen flex flex-wrap justify-center md:justify-normal">
        {#each boards as board}
            <a href={"/digibord/"+board.id} use:inertia>
                <div class="bg-[#C4F0FF] text-center flex justify-center items-center w-80 md:w-56 ml-4 mr-4 mb-4 p-3 hover:text-white">
                    <h2 class="text-xl">{board.Title}</h2>
                </div>
            </a>
        {/each}

        <div class="bg-[#C4F0FF] text-center flex justify-center items-center w-80 md:w-56 ml-4 mr-4 mb-4 p-3 hover:cursor-pointer hover:bg-[#0000AB] hover:text-white"
        on:click={()=>{NBModal = true}}>
            <h2 class="text-xl"> + </h2>
        </div>

    </div>

</div>
