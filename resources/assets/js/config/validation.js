import { Validator } from 'vee-validate'
import Message_zh_CN from '../locale/zh_CN/validation';

Validator.updateDictionary({
    zh_CN: Message_zh_CN
});

const config ={
	locale: 'zh_CN'
}

export default config