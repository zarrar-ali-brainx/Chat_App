import {ref} from "vue";
const d = new Date()
const h = d.getHours()
const m = d.getMinutes()
const time = h + ':' + m;
const msgTime = () =>{
    return (h + '' + m)
}
export const messages = [{
    msg: 'Hi',
    msgTime: '19:30'
},
    {
        msg: 'Hi',
        msgTime: '19:30'
    },
    {
        msg: 'Hi',
        msgTime: '19:30'
    },
    {
        msg: 'Hi',
        msgTime: '19:30'
    },
];

