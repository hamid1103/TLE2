<script>
    export let modalClose, ChatID, CEPreview, boards;
    let NameEmpty = false
    let isLoading=false;
    let BoardID;
    let AssignToBoard = async ()=>{
        isLoading = true
        axios.post("/addQuestionToBoard", {chatEntryID: ChatID, boardID: BoardID})
            .then(res=>{
                modalClose()
            })
    }

</script>

<div
    class="fixed h-screen w-screen bg-gray-700 bg-opacity-75 flex flex-col justify-center align-middle items-center z-50">
    <div class="w-11/12 md:w-3/5 flex justify-end bg-white">
    <div class={"" + isLoading ? "bg-gray-700" : "bg-blue-600"}>
        <button class="bg-red-500 w-16 " on:click={()=>{modalClose(); console.log("Modal should be closed rn")}}>
            X
        </button>
    </div>
</div>
    <div class="w-11/12 md:w-3/5 p-4 bg-white opacity-100 flex flex-wrap justify-between">
        {#each boards as board}
            <button class="rounded bg-blue-300 w-full md:w-5/12 text-xl mx-8 my-4 p-2" on:click={()=>{
                BoardID = board.id
                AssignToBoard()
            }}>
                {board.Title}
            </button>
        {/each}
    </div>
    {#if isLoading}
        <span class="text-xl text-white font-bold uppercase">Loading</span>
    {/if}
</div>
