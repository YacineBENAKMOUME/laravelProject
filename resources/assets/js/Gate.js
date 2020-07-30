export default class Gate{
    
    constructor(user){
        this.user = user;
    }

    isRst(){
        return this.user.type === 'RST';
    }
    
    isRsf(){
        return this.user.type === 'RSF';
    }

    isRelex(){
        return this.user.type === 'Service Relex';
    }

    isChefdepartement(){
        return this.user.type === 'Chef de Département';
    }



}