# Form Rendering and Variables

Let’s talk about form rendering. It looks really nice right now, but all we’re doing to render all the fields is just this one line here. That doesn’t let us customize the order of the fields, and it’s not gonna let us do a couple other customizations that we’re gonna wanna do.

So, in reality, I don’t usually use form_widget like this to render all my fields. Instead, I use a different function called form_row, and you pass that the-name-of-your-form.the-name-of-your-field, name.

So, in our case, we have 1, 2, 3, 4, 5, 6 fields, so I’m gonna copy that and paste it six times, and then I’m just gonna fill in our different fields, which is subfamily, speciesCount, funFact, isPublished, and firstDiscoveredAt. And if you refresh, you’re gonna see the exact same thing as before. The form widget we were using, this is what it does behind the scenes. It just loops over all of our fields and calls form_row. 

So, at this point, we need to be asking, “What else can I do? What other functions are there? What options can I pass these functions?” So Google for “form function twig” to find another reference section called “Twig Template Form Function and Variable Reference.” This you reference for all the form functions do. 

The ones I want you to notice right now are, of course, form_row, and this renders the three parts to a field, which are the label for the field, the widget – which is the actual input field itself – and any validation errors for that field. If you ever need to render those individually, there’s also a form_widget function, form_errors function, and a form_label function. You can use that instead of form_row, but try to use form_row as much as possible because then you can keep all your form fields looking exactly alike.

Now notice, most of these functions, including form_row, the second variable argument is called variables, and judging by this code example down here, apparently you can override the label for the field right there. So, this variables thing is incredibly powerful. It allows you to override almost every part of how the field is rendered.

If you scroll down to the bottom of this page, you’ll see a Form Variables Reference section. This gives you a big list of all the variables that you can override when rendering a field, including label, attr, label_attr, and other things.

So, to show this off, let’s go to speciesCount and do a comma, open up a twig array, and then, we’ll override the label to say ‘Number of Species’. Go back, refresh, and it’s just that easy.

Now, one other thing we haven’t looked at is as soon as you start using a form, you have a little clipboard down here. This is the web debug toolbar for your form, and it gives lots of really good information about your form itself. You can see how the form is built. If you click to speciesCount, you can see the different data for your species, which is not very interesting in this case because we have a blank form, any submitted data, and all of the variables that can be passed to that field.

The reference section we looked at is most of the variables but not all of the variables, so this is your place to actually know, “What are my values for my variables, and what can I override?”

This also shows you the Resolved Options, so these are the options that are passed when you actually build your form type. So, if you want a really good way to figure out what else can you pass as the third argument to add, this is the full list of all of the options that are passed to that field. So, there’s just a really powerful, good debugging stuff inside of here.

Also, check out this _token field. We did not add this to our form, but there it is. This is a CSRF token that’s automatically added to our form. It’s really cool because it protects us from CSRF attacks, but we don’t have to worry about it at all. It’s rendered when we call form_end because this renders all of the hidden fields automatically, so we don’t have to worry about rendering it. And when we submit, it’s automatically validated for us. So, just be aware that CSRF token’s there, but you don’t have to worry about it. If you ever get a validation message about the CSRF token, just make sure that you have form_end. The most likely cause is that you forgot to render the field.
