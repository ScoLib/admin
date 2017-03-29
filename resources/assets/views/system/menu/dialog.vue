<template>
    <div class="form-horizontal">

        <div :class="['form-group', errors.pid ? 'has-error' : '']">
            <label class="control-label col-xs-12 col-sm-3 no-padding-right" for="pid">父级菜单</label>

            <div class="col-xs-12 col-sm-9">
                <div class="clearfix">
                    <select class="input-medium" name="pid" v-model="info.pid">
                        <option value="0">顶级菜单</option>

                        <option :value="menu.id" v-for="menu in menuList"><i v-html="menu.spacer"></i>{{menu.display_name}}</option>
                    </select>
                </div>
                <div class="help-block">This field is required.</div>
            </div>
        </div>

        <div class="space-2"></div>

        <div :class="['form-group', errors.display_name ? 'has-error' : '']">
            <label class="control-label col-xs-12 col-sm-3 no-padding-right" for="display_name">显示名称</label>

            <div class="col-xs-12 col-sm-9">
                <div class="clearfix">
                    <input class="col-xs-12 col-sm-4" type="text" id="display_name" name="display_name" v-model="info.display_name">
                </div>
                <div class="help-block" v-if="errors.display_name">{{ errors.display_name[0] }}</div>
            </div>
        </div>

        <div class="space-2"></div>

        <div :class="['form-group', errors.name ? 'has-error' : '']">
            <label class="control-label col-xs-12 col-sm-3 no-padding-right" for="name">显示名称</label>

            <div class="col-xs-12 col-sm-9">
                <div class="clearfix">
                    <input type="text" data-toggle="tooltip"
                           data-original-title="必须是路由的别名，如不是链接，则填“#”" id="name" name="name" class="col-xs-12 col-sm-4 tooltips" placeholder="admin.system.menu" v-model="info.name">
                </div>
                <div class="help-block">Please specify a password.</div>
            </div>
        </div>

        <div class="hr hr-dotted"></div>

        <div :class="['form-group', errors.icon ? 'has-error' : '']">
            <label class="control-label col-xs-12 col-sm-3 no-padding-right" for="icon">图标</label>

            <div class="col-xs-12 col-sm-9">
                <div class="clearfix">
                    <input type="text" id="icon" name="icon" class="col-xs-12 col-sm-8"
                           placeholder="fa-" v-model="info.icon">
                </div>
                <div class="help-block">Please specify a password.</div>
            </div>
        </div>

        <div class="space-2"></div>

        <div class="form-group has-error">
            <label class="control-label col-xs-12 col-sm-3 no-padding-right" for="phone">Phone Number:</label>

            <div class="col-xs-12 col-sm-9">
                <div class="input-group">
																		<span class="input-group-addon">
																			<i class="ace-icon fa fa-phone"></i>
																		</span>

                    <input type="tel" id="phone" name="phone" aria-required="true" aria-describedby="phone-error">
                </div><div id="phone-error" class="help-block">This field is required.</div>
            </div>
        </div>

        <div class="space-2"></div>

        <div class="form-group has-error">
            <label class="control-label col-xs-12 col-sm-3 no-padding-right" for="url">Company URL:</label>

            <div class="col-xs-12 col-sm-9">
                <div class="clearfix">
                    <input type="url" id="url" name="url" class="col-xs-12 col-sm-8" aria-required="true" aria-describedby="url-error">
                </div><div id="url-error" class="help-block">This field is required.</div>
            </div>
        </div>

        <div class="hr hr-dotted"></div>

        <div class="form-group has-error">
            <label class="control-label col-xs-12 col-sm-3 no-padding-right">Subscribe to</label>

            <div class="col-xs-12 col-sm-9">
                <div>
                    <label>
                        <input name="subscription" value="1" type="checkbox" class="ace" aria-required="true" aria-describedby="subscription-error">
                        <span class="lbl"> Latest news and announcements</span>
                    </label>
                </div>

                <div>
                    <label>
                        <input name="subscription" value="2" type="checkbox" class="ace">
                        <span class="lbl"> Product offers and discounts</span>
                    </label>
                </div>
                <div id="subscription-error" class="help-block">Please choose at least one option</div></div>
        </div>

        <div class="space-2"></div>

        <div :class="['form-group', errors.is_menu ? 'has-error' : '']">
            <label class="control-label col-xs-12 col-sm-3 no-padding-right">菜单</label>

            <div class="col-xs-12 col-sm-9">
                <div>
                    <label class="line-height-1 blue">
                        <input name="is_menu" value="1" type="radio" class="ace" v-model="info.is_menu">
                        <span class="lbl"> 是</span>
                    </label>
                </div>

                <div>
                    <label class="line-height-1 blue">
                        <input name="is_menu" value="0" type="radio" class="ace" v-model="info.is_menu">
                        <span class="lbl"> 否</span>
                    </label>
                </div>
                <div class="help-block" v-if="errors.is_menu">{{ errors.is_menu }}</div>
            </div>
        </div>

        <div class="hr hr-dotted"></div>

        <div class="form-group has-error">
            <label class="control-label col-xs-12 col-sm-3 no-padding-right" for="state">State</label>

            <div class="col-xs-12 col-sm-9">
                <select id="state" name="state" class="select2 select2-hidden-accessible" data-placeholder="Click to Choose..." style="width: 200px;" tabindex="-1" aria-hidden="true" aria-required="true" aria-describedby="state-error">
                    <option value="">&nbsp;</option>
                    <option value="AL">Alabama</option>
                    <option value="AK">Alaska</option>
                    <option value="AZ">Arizona</option>
                    <option value="AR">Arkansas</option>
                    <option value="CA">California</option>
                    <option value="CO">Colorado</option>
                    <option value="CT">Connecticut</option>
                    <option value="DE">Delaware</option>
                    <option value="FL">Florida</option>
                    <option value="GA">Georgia</option>
                    <option value="HI">Hawaii</option>
                    <option value="ID">Idaho</option>
                    <option value="IL">Illinois</option>
                    <option value="IN">Indiana</option>
                    <option value="IA">Iowa</option>
                    <option value="KS">Kansas</option>
                    <option value="KY">Kentucky</option>
                    <option value="LA">Louisiana</option>
                    <option value="ME">Maine</option>
                    <option value="MD">Maryland</option>
                    <option value="MA">Massachusetts</option>
                    <option value="MI">Michigan</option>
                    <option value="MN">Minnesota</option>
                    <option value="MS">Mississippi</option>
                    <option value="MO">Missouri</option>
                    <option value="MT">Montana</option>
                    <option value="NE">Nebraska</option>
                    <option value="NV">Nevada</option>
                    <option value="NH">New Hampshire</option>
                    <option value="NJ">New Jersey</option>
                    <option value="NM">New Mexico</option>
                    <option value="NY">New York</option>
                    <option value="NC">North Carolina</option>
                    <option value="ND">North Dakota</option>
                    <option value="OH">Ohio</option>
                    <option value="OK">Oklahoma</option>
                    <option value="OR">Oregon</option>
                    <option value="PA">Pennsylvania</option>
                    <option value="RI">Rhode Island</option>
                    <option value="SC">South Carolina</option>
                    <option value="SD">South Dakota</option>
                    <option value="TN">Tennessee</option>
                    <option value="TX">Texas</option>
                    <option value="UT">Utah</option>
                    <option value="VT">Vermont</option>
                    <option value="VA">Virginia</option>
                    <option value="WA">Washington</option>
                    <option value="WV">West Virginia</option>
                    <option value="WI">Wisconsin</option>
                    <option value="WY">Wyoming</option>
                </select><span class="select2 select2-container select2-container--default" dir="ltr" style="width: 200px;"><span class="selection"><span class="select2-selection select2-selection--single" role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="0" aria-labelledby="select2-state-container"><span class="select2-selection__rendered" id="select2-state-container"><span class="select2-selection__placeholder">Click to Choose...</span></span><span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span></span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span><div id="state-error" class="help-block">Please choose state</div>
            </div>
        </div>

        <div class="space-2"></div>

        <div class="form-group has-error">
            <label class="control-label col-xs-12 col-sm-3 no-padding-right" for="platform">Platform</label>

            <div class="col-xs-12 col-sm-9">
                <div class="clearfix">
                    <select class="input-medium" id="platform" name="platform" aria-required="true" aria-describedby="platform-error">
                        <option value="">------------------</option>
                        <option value="linux">Linux</option>
                        <option value="windows">Windows</option>
                        <option value="mac">Mac OS</option>
                        <option value="ios">iOS</option>
                        <option value="android">Android</option>
                    </select>
                </div><div id="platform-error" class="help-block">This field is required.</div>
            </div>
        </div>

        <div class="space-2"></div>

        <div class="form-group has-error">
            <label class="control-label col-xs-12 col-sm-3 no-padding-right" for="comment">Comment</label>

            <div class="col-xs-12 col-sm-9">
                <div class="clearfix">
                    <textarea class="input-xlarge" name="comment" id="comment" aria-required="true" aria-describedby="comment-error"></textarea>
                </div><div id="comment-error" class="help-block">This field is required.</div>
            </div>
        </div>

        <div class="space-8"></div>

        <div class="form-group has-error">
            <div class="col-xs-12 col-sm-4 col-sm-offset-3">
                <label>
                    <input name="agree" id="agree" type="checkbox" class="ace" aria-required="true" aria-describedby="agree-error">
                    <span class="lbl"> I accept the policy</span><div id="agree-error" class="help-block">Please accept our policy</div>
                </label>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
//                info: {},
//                menuList: [],
            }
        },
        computed: {
        },
        props: {
            menuList: {
                type: Object,
                default() {
                    return {}
                }
            },
            info: {
                type: Object,
                default() {
                    return {}
                }
            },
            errors: {
                type: Object,
                default() {
                    return {}
                }
            }
        },
        methods: {
        },
    }
</script>