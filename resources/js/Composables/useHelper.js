export function useHelper() {
    const getInitials = (fullName) => {
        if (!fullName) return;
        const words = fullName.split(" ");
        return words.map(word => word[0]).join("");
    }
    return {
        getInitials
    }
}