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
    <div class={"w-3/5 flex justify-end " + isLoading ? "bg-gray-700" : "bg-blue-600"}>
        <button class="bg-red-500 w-24" on:click={()=>{modalClose(); console.log("Modal should be closed rn")}}>X
        </button>
    </div>
    <div class="w-3/5 h-1/6 bg-blue-600 opacity-100 flex justify-center overflow-y-auto items-center">
        {#each boards as board}
            <button class="rounded bg-white w-24 h-24 mr-4" on:click={()=>{
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
