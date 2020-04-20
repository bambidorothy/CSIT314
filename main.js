class UserAccount { //create Person class
    constructor(fullName, userid, password, role) { //create constructor fields
        this.fullName = fullName;
        this.userid = userid;
        this.password = password;
        this.role = role;
    }
    display() { //display name function
        return "Welcome " + this.fullName + "!" + "<br>" + "Your userid is " + this.userid + "!"+ "<br>" + "Your role is " + this.role + "!";
    }
}
let user = new UserAccount('Dorothy', 's001', 123456, 'student'); //create user object of person class

document.getElementById("demo").innerHTML = user.display();
console.log("Welcome " + this.fullName + "!" + "Your userid is " + this.userid + "!"+ "Your role is " + this.role + "!");