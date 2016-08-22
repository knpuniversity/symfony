# Complex Blocks Parent Function

Right now, we're adding this glyph icon to every single field that has an error, but we just found out that we only really want to add this to input fields. I know that this is a text type, so maybe what we want to do is instead of having this logic here, we want to override the text_widget. We can add this there so it only affects text fields.

Let's go into our form_[inaudible 00:00:39] for layout and let's look for text_widget. Guess what? We don't actually find it in here. That must mean that instead of text_widget it looks for form_widget. In fact, that block does exist.

Now, check this out. Remember that compound variable we talked about where some fields are just single fields and some fields are actually apparent fields consisting of many sub-fields? In our form, all of our fields right now are simple. They're not compound. In other words, for a normal text field it gets down this else, this actually just says, "Go render this other block called form widget simple." It turns out if we want to override the text field, in fact, if we want to override any input fields because you can see this is the input tab, we use form widget simple.

Let's override this, but wait. First, I want to actually see if this was overwritten inside boot chapter layout. In fact, it was overwritten. This is the one that we want to copy and then paste and do our form theme template. Now inside these form theme templates you're going to see some of the craziest twig code that you'll see anywhere. If you look at this logic, it actually says, "If type is not defined, or file does not equal type then effectively add a new class attribute called form-control."

The way it does that is it actually takes the existing ATTR array and then calls array merge on it and merges in this new class but then adds a space form control if there already is a class. Phew! It's a lot of heavy lifting sometimes to get a little bit of work done inside of these twig templates.

Without making any changes though, let's actually go over and refresh. It surprisingly doesn't work. Calling parent on a template that does not extend or use another template is forbidden. This is coming from down here on this parent thing. We understand that in normal twig templates, you can override blocks and then call the parent function which checks this out. This does not extend another twig template and we don't want it to. These two templates are a little bit different, but effectively what we do want to do is kind of call the form widget simple block from this parent template.

This work before in the bootstrap template because of this use template. What this says is, don't actually extend this other template, but if I call parent, allow me to use the blocks inside that template. Again, these templates are just weird. This is what we want to do inside of our form theme.

Up top, we're going to say, "Use bootstrap 3_layout@html@twig. As soon as we do that, life is good. In fact, we don't have to have this logic anymore because we're calling the parent function, that's already going to be done inside of the parent block. After refresh that still looks good and still has the class.

Finally, we can move our logic. First of all, keep the show error icon because we do need to keep the haz feedback class on this outer element. I'm going to copy that variable and actually move it down here inside the if statements. It turns out that we probably also don't want to show the error icon on the file upload field, so we will actually set the show error icon=false and then if it's a file, not a file, then we will actually send it down here. I can do that all in one line but it would be super long and super ugly.

Then we'll actually copy the if statement for the span and move it down here right after the parent call and that should do it. You see the error icon here, we don't see the error icon dropdown below it. Phew! Form demi is all about finding the correct format to override and then leveraging your variables and actually even modifying some variables.
